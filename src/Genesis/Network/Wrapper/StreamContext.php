<?php
/**
 * Stream Context Network Interface
 *
 * @package Genesis
 * @subpackage Network
 */

namespace Genesis\Network\Wrapper;

use \Genesis\Utils as Utils;
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
            'Content-Type: text/xml',
            sprintf('Content-Length: %s', strlen($requestData['body'])),
            sprintf('User-Agent: %s', $requestData['user_agent']),
            sprintf('Authorization: Basic %s', base64_encode($requestData['user_login'])),

        );

        $contextOptions = array(
            'http'  => array(
                'method'    => $requestData['type'],
                'header'    => implode("\r\n", $headers),
                'content'   => $requestData['body'],
            ),
            'ssl'   => array(
                // DO NOT allow self-signed certificates
                'allow_self_signed'     => false,
                // Path to certificate/s PEM files used to validate the server authenticity
                'cafile'                => $requestData['cert_ca'],
                // Validate Certificates
                'verify_peer'           => true,
                // Abort if the certificate-chain is longer than 5 nodes
                'verify_depth'          => 5,
                // SNI causes errors due to improper handling of alerts by OpenSSL in 0.9.8
                // As many php releases are linked against 0.9.8, its better to disable SNI
                // in case you can't upgrade.
                'SNI_enabled'           => true,
                // You can tweak what Ciphers should be used (if available), this list is
                // recommended by Mozilla and its built with 'Forward Secrecy' in mind
                'ciphers'               => 'ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-ECDSA-AES256-GCM-SHA384:DHE-RSA-AES128-GCM-SHA256:DHE-DSS-AES128-GCM-SHA256:kEDH+AESGCM:ECDHE-RSA-AES128-SHA256:ECDHE-ECDSA-AES128-SHA256:ECDHE-RSA-AES128-SHA:ECDHE-ECDSA-AES128-SHA:ECDHE-RSA-AES256-SHA384:ECDHE-ECDSA-AES256-SHA384:ECDHE-RSA-AES256-SHA:ECDHE-ECDSA-AES256-SHA:DHE-RSA-AES128-SHA256:DHE-RSA-AES128-SHA:DHE-DSS-AES128-SHA256:DHE-RSA-AES256-SHA256:DHE-DSS-AES256-SHA:DHE-RSA-AES256-SHA:AES128-GCM-SHA256:AES256-GCM-SHA384:ECDHE-RSA-RC4-SHA:ECDHE-ECDSA-RC4-SHA:AES128:AES256:RC4-SHA:HIGH:!aNULL:!eNULL:!EXPORT:!DES:!3DES:!MD5:!PSK:!SSLv2',
            )
        );

	    // Warn about unsupported version
	    if (Utils\Common::getPHPVersion() < 50302) {
		    throw new \Exception('Unsupported version, please upgrade your PHP installation or switch to cURL');
	    }

	    // Note: Mitigate CRIME/BEAST attacks
	    if (Utils\Common::getPHPVersion() > 50413) {
			$contextOptions['ssl']['disable_compression'] = true;
	    }

	    // Note: PHP does NOT support SAN certs on PHP version < 5.6
        if (Utils\Common::getPHPVersion() < 50600) {
            $contextOptions['ssl']['CN_match']          = $url['host'];
            $contextOptions['ssl']['SNI_server_name']   = $url['host'];
        }
        else {
            $contextOptions['ssl']['peer_name']         = $url['host'];
            $contextOptions['ssl']['verify_peer_name']  = true;
        }

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
