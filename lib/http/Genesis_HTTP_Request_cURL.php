<?php

namespace Genesis;


class Genesis_HTTP_Request_cURL extends Genesis_Base
{
    public $response;

    private $curlHandle;

    /**
     * Initialize cURL upon instantiating
     *
     */
    public function __construct()
    {
        $this->curlHandle = curl_init();
    }

    /**
     * Flush and destroy cURL instance upon destruction
     *
     */
    public function __destruct()
    {
        curl_close($this->curlHandle);
    }

    /**
     * Set a reference to the API Request, so we can
     * build the query and populate the content of
     * the request
     *
     * @param $api_request
     */
    public function setRequest($api_request)
    {
        $this->apiRequest = $api_request;
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
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_TIMEOUT         => 60,
            CURLOPT_URL             => $requestData['url'],
            CURLOPT_USERAGENT       => $requestData['user_agent'],
            CURLOPT_USERPWD         => $requestData['user_login'],
        );

        if($requestData['type'] == 'POST') {
            $cURLOpt[CURLOPT_POST]              = false;
            $cURLOpt[CURLOPT_POSTFIELDS]        = $requestData['body'];
        }

        if ($requestData['ssl']) {
            $cURLOpt[CURLOPT_CAINFO]            = $requestData['cert_ca'];
            $cURLOpt[CURLOPT_SSL_VERIFYPEER]    = true;
            $cURLOpt[CURLOPT_SSL_VERIFYHOST]    = 2;
        }

        if ($requestData['debug']) {
            $cURLOpt[CURLOPT_VERBOSE]           = true;
        }

        $this->setOptions($cURLOpt);
    }

    /**
     * submitRequest the request
     *
     * @return mixed
     * @throws Genesis_Exception_Invalid_SSL_Certificate_Authority
     */
    public function submitRequest()
    {
        $this->response = curl_exec($this->curlHandle);
    }

    private function setOptions($curlOptions)
    {
        curl_setopt_array($this->curlHandle, $curlOptions);
    }
} 