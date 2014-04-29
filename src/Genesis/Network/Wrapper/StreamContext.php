<?php

namespace Genesis\Network\Wrapper;

class StreamContext
{
    private $requestData;
    private $streamContext;

    private $response;
    private $responseBody;
    private $responseHeaders;

    /**
     * Get the HTTP Status of the request
     *
     * @return mixed
     */
    public function getStatus()
    {
        return substr($this->response, 9, 3);
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
        $url = parse_url($requestData['url']);

        $contextOptions = array(
            'http'  => array(
                'method'    => $requestData['type'],
                'header'    =>  "Authorization: Basic " . base64_encode($requestData['user_login']) . "\r\n" .
                                "Content-Type: text/xml\r\n" .
                                "Content-Length: " . strlen($requestData['body']) . "\r\n" .
                                "User-Agent: " . $requestData['user_agent'] . "\r\n" ,
                'content'   => $requestData['body'],
            ),
            'ssl'   => array(
                'verify_peer'   => true,
                'cafile'        => $requestData['cert_ca'],
                'verify_depth'  => 5,
                // PHP does not support SAN matchin (as of yet), so any certificate with
                // SAN would fail this check
                'CN_match'      => $url['host'],
                'disable_compression' => true,
                // SNI causes errors due to improper handling of alerts by OpenSSL in 0.9.8
                // As many php releases are linked against 0.9.8, its better to disable SNI
                'SNI_enabled'         => false,
                'ciphers'             => 'ALL!EXPORT!EXPORT40!EXPORT56!aNULL!LOW!RC4'
            )
        );

        $this->streamContext = stream_context_create($contextOptions);

        $this->requestData = $requestData;
    }

    /**
     * Execute the prepared request
     */
    public function submitRequest()
    {
        $this->responseBody = file_get_contents($this->requestData['url'], NULL, $this->streamContext);

        $this->responseHeaders  = $http_response_header;

        $this->response = implode("\r\n", $http_response_header) . "\r\n\r\n" . $this->responseBody;

        if (empty($this->response)) {
            throw new \Genesis\Exceptions\InvalidSSLCA();
        }
    }
}
