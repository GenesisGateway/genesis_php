<?php
/**
 * Stream Context Network Interface
 *
 * @package Genesis
 * @subpackage Network
 */

namespace Genesis\Network\Wrapper;

use \Genesis\Exceptions as Exceptions;
use \Genesis\Network\NetworkInterface as NetworkInterface;

class StreamContext implements NetworkInterface
{
    /**
     * Keep per-request data as other methods need it
     * @var array
     */
    private $requestData;
    /**
     * Storing Stream parameters
     * @var Resource
     */
    private $streamContext;

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

    /**
     * Get HTTP Status Code from an incoming response
     *
     * @return mixed
     */
    public function getStatus()
    {
        return substr($this->response, 9, 3);
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
     * Set Stream parameters: url, data, auth etc.
     */
    public function prepareRequestBody($requestData)
    {
        $url = parse_url($requestData['url']);

        $headers = array(
            sprintf('Authorization: Basic %s', base64_encode($requestData['user_login'])),
            sprintf('Content-Length: %s', strlen($requestData['body'])),
            sprintf('User-Agent: %s', $requestData['user_agent']),
            'Content-Type: text/xml',
        );

        $contextOptions = array(
            'http'  => array(
                'method'    => $requestData['type'],
                'header'    => implode("\r\n", $headers),
                'content'   => $requestData['body'],
            ),
            'ssl'   => array(
                'verify_peer'   => true,
                'cafile'        => $requestData['cert_ca'],
                'verify_depth'  => 5,
                // PHP does not support SAN matching (as of yet), so any certificate with
                // SAN would fail this check
                'CN_match'      => $url['host'],
                // Mitigate BEAST attacks
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
     * Send the request
     */
    public function execute()
    {
        $stream = fopen($this->requestData['url'], 'r', false, $this->streamContext);

        if (!$stream) {
            throw new Exceptions\InvalidSSLCA();
        }

        $this->responseBody = stream_get_contents($stream);

        $this->responseHeaders = $http_response_header;

        $this->response = implode("\r\n", $http_response_header) . "\r\n\r\n" . $this->responseBody;
    }
}
