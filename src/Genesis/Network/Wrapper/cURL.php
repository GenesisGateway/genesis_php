<?php

namespace Genesis\Network\Wrapper;

class cURL
{
    private $curlHandle;

    private $response;
    private $responseBody;
    private $responseHeaders;


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
     * Get Response Headers
     *
     * @return mixed
     */
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     * Get Response Body
     *
     * @return mixed
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * Set cURL headers/options, according to the request
     */
    public function prepareRequestBody($requestData)
    {
        $cURLOpt = array(
            CURLOPT_ENCODING        => 'gzip',
            CURLOPT_HEADER          => true,
            CURLOPT_HTTPHEADER      => array('Content-Type: text/xml', 'Expect:'),
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
        list($this->responseHeaders, $this->responseBody) = explode("\r\n\r\n", $this->response, 2);
    }

    /**
     * Helper function to set all cURL options, passed as array
     *
     * @param $curlOptions Array
     */
    public function setOptions($curlOptions)
    {
        curl_setopt_array($this->curlHandle, $curlOptions);
    }
}
