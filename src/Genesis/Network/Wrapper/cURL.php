<?php
/**
 * cURL Network Interface
 * Note: requires php curl extension
 *
 * @package Genesis
 * @subpackage Network
 */

namespace Genesis\Network\Wrapper;

use \Genesis\Network\NetworkInterface as NetworkInterface;

class cURL implements NetworkInterface
{
    /**
     * Storing cURL Handle
     * @var resource
     */
    private $curlHandle;

    /**
     * Storing the full incoming response
     * @var string
     */
    private $response;
    /**
     * Storing body from an incoming response
     * @var string
     */
    private $responseBody;
    /**
     * Storing headers from an incoming response
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
	        $cURLOpt[CURLOPT_SSLVERSION]        = 1; // CURL_SSLVERSION_TLSv1
            $cURLOpt[CURLOPT_SSL_VERIFYPEER]    = true;
            $cURLOpt[CURLOPT_SSL_VERIFYHOST]    = 2;
        }

        curl_setopt_array($this->curlHandle, $cURLOpt);
    }

    /**
     * Send the request
     */
    public function execute()
    {
        $this->response = curl_exec($this->curlHandle);
        list($this->responseHeaders, $this->responseBody) = explode("\r\n\r\n", $this->response, 2);
    }
}
