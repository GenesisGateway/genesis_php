<?php

namespace Genesis\Network\Wrapper;

/**
 * cURL Network Interface
 * Note: requires php curl extension
 *
 * @package Genesis
 * @subpackage Network
 */
class cURL implements \Genesis\Network\NetworkInterface
{
    /**
     * Storing cURL Handle
     *
     * @var resource
     */
    private $curlHandle;

    /**
     * Storing the full incoming response
     *
     * @var string
     */
    private $response;

    /**
     * Storing body from an incoming response
     *
     * @var string
     */
    private $responseBody;

    /**
     * Storing headers from an incoming response
     *
     * @var string
     */
    private $responseHeaders;


    public function __construct()
    {
        $this->curlHandle = curl_init();
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
     * Get Body/Headers from an incoming response
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get Headers from an incoming response
     *
     * @return mixed
     */
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     * Get Body from an incoming response
     *
     * @return mixed
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * Set cURL headers/options, based on the request data
     *
     * @return void
     */
    public function prepareRequestBody($requestData)
    {
        $options = array(
            CURLOPT_ENCODING        => 'gzip',
            CURLOPT_HEADER          => true,
            CURLOPT_HTTPHEADER      => array('Content-Type: text/xml', 'Expect:'),
            CURLOPT_HTTPAUTH        => CURLAUTH_BASIC,
            CURLOPT_URL             => $requestData['url'],
            CURLOPT_TIMEOUT         => $requestData['timeout'],
            CURLOPT_USERAGENT       => $requestData['user_agent'],
            CURLOPT_USERPWD         => $requestData['user_login'],
            CURLOPT_RETURNTRANSFER  => true,
	        // SSL/TLS Configuration
            CURLOPT_CAINFO          => $requestData['ca_bundle'],
            CURLOPT_SSL_VERIFYPEER  => true,
            CURLOPT_SSL_VERIFYHOST  => 2,
        );

	    $post = array(
		    CURLOPT_POST            => false,
		    CURLOPT_POSTFIELDS      => $requestData['body']
	    );

        if('POST' == strtoupper($requestData['type'])) {
            $options = array_merge($options, $post);
        }

        curl_setopt_array($this->curlHandle, $options);
    }

    /**
     * Send the request
     *
     * @return void
     *
     * @throws
     */
    public function execute()
    {
        $this->response = curl_exec($this->curlHandle);

	    $this->checkForErrors();

        list($this->responseHeaders, $this->responseBody) = explode("\r\n\r\n", $this->response, 2);
    }

	/**
	 * Check whether or not a cURL request is successful
	 *
	 * @return string
	 * @throws \Genesis\Exceptions\NetworkError
	 */
	private function checkForErrors()
	{
		$errNo  = curl_errno($this->curlHandle);
		$errStr = curl_error($this->curlHandle);

		if ($errStr) {
			throw new \Genesis\Exceptions\NetworkError($errStr, $errNo);
		}
	}
}
