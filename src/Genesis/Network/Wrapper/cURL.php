<?php

namespace Genesis\Network\Wrapper;

class cURL
{
    public $response;

    private $curlHandle;

    public function __construct()
    {
        $this->curlHandle = curl_init();
    }

    /**
     * Flush and destroy cURL instance upon destruction
     */
    public function __destruct()
    {
        if (isset($this->curlHandle))
            curl_close($this->curlHandle);
    }

    /**
     * Get the HTTP Status of the request
     *
     * @return mixed
     */
    public function getStatus()
    {
        return curl_getinfo($this->curlHandle, CURLINFO_HTTP_CODE);
    }

    /**
     * Get cURL's cached exec output
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set cURL headers/options, according to the request
     */
    public function prepareRequestBody($requestData)
    {
        $cURLOpt = array(
            CURLOPT_ENCODING        => 'gzip',
            CURLOPT_HTTPHEADER      => array('Content-Type: text/xml'),
            CURLOPT_HTTPAUTH        => CURLAUTH_BASIC,
            CURLOPT_URL             => $requestData['url'],
            CURLOPT_TIMEOUT         => $requestData['timeout'],
            CURLOPT_USERAGENT       => $requestData['user_agent'],
            CURLOPT_USERPWD         => $requestData['user_login'],
            CURLOPT_RETURNTRANSFER  => true,
        );

        if($requestData['type'] == 'POST') {
            $cURLOpt[CURLOPT_POST]              = false;
            $cURLOpt[CURLOPT_POSTFIELDS]        = $requestData['body'];
        }

        if ($requestData['protocol'] == 'https') {
            $cURLOpt[CURLOPT_CAINFO]            = $requestData['cert_ca'];
            $cURLOpt[CURLOPT_SSL_VERIFYPEER]    = true;
            $cURLOpt[CURLOPT_SSL_VERIFYHOST]    = 2;
        }

        if ($requestData['debug']) {
            $cURLOpt[CURLOPT_VERBOSE]           = true;
            $cURLOpt[CURLINFO_HEADER_OUT]       = true;
        }

        $this->setOptions($cURLOpt);
    }

    /**
     * Execute the prepared request
     */
    public function submitRequest()
    {
        $this->response = curl_exec($this->curlHandle);
    }

    /**
     * Helper function to set all cURL options, passed as array
     *
     * @param $curlOptions Array
     */
    private function setOptions($curlOptions)
    {
        curl_setopt_array($this->curlHandle, $curlOptions);
    }
}
