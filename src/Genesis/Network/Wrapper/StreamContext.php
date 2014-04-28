<?php

namespace Genesis\Network\Wrapper;

class StreamContext
{
    public $response;

    private $responseBody;
    private $responseHeaders;

    private $requestData;
    private $socketHandle;
    private $streamContext;

    /**
     * Null-ify the Socket Handle to avoid memory leaks
     */
    public function __destruct()
    {
        if (isset($this->socketHandle)) {
            $this->socketHandle = null;
        }
    }

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
        $auth_header = sprintf('Authorization: Basic %s', base64_encode($requestData['user_login']));

        $streamParameters = array(
            'http' => array(
                'method'        => $requestData['type'],
                'header'        =>
                    $auth_header . "\r\n" .
                    "Content-Type: text/xml\r\n" .
                    "Content-Encoding: gzip\r\n"
                ,
                'content'       => $requestData['body'],
                'timeout'       => 60,
                'user_agent'    => $requestData['user_agent'],
            )
        );

        if ($requestData['protocol'] == 'https') {
            $streamParameters['ssl'] = array(
                'verify_peer'           => true,
                'cafile'                => $requestData['cert_ca'],
            );
        }

        $this->requestData = $requestData;
        $this->streamContext = stream_context_create($streamParameters);
    }

    /**
     * Execute the prepared request
     */
    public function submitRequest()
    {
        $this->socketHandle = stream_socket_client($this->requestData['transport_url'], $errorCode, $errorMessage, 60, STREAM_CLIENT_CONNECT, $this->streamContext);

        if (!$this->socketHandle) {
            throw new \Exception($errorMessage, $errorCode);
        }
        else {
            fwrite($this->socketHandle, $this->buildRAWQuery());
            /*
            //$start = NULL;
            //while (!$this->safeTimeout($this->socketHandle, $start) && (microtime(true) - $start) < 1) {
             */
            while (!feof($this->socketHandle)) {
                $this->response .= fgets($this->socketHandle, 4096);
            }

            list($this->responseHeaders, $this->responseBody) = explode("\r\n\r\n", $this->response, 2);

            fclose($this->socketHandle);
        }
    }

    private function buildRAWQuery()
    {
        $data = $this->requestData;

        $url = parse_url($this->requestData['url']);

        $raw =  "POST " . $url['path'] . " HTTP/1.1\r\n" .
                "Host: " . $url['host'] . "\r\n" .
                "Authorization: Basic " . base64_encode($data['user_login']) . "\r\n" .
                "User-Agent: " . $data['user_agent'] . "\r\n" .
                "Content-Length: " . strlen($data['body']) . "\r\n" .
                "Content-Type: text/xml\r\n" .
                "\r\n" .
                $data['body'] .
                "\r\n";

        return $raw;
    }

    /*
    private function safeTimeout($handle, &$start = null)
    {
        $start = microtime(true);

        return feof($handle);
    }
    */
}
