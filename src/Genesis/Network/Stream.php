<?php
/*
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
namespace Genesis\Network;

/**
 * Stream Context Network Interface
 *
 * @package    Genesis
 * @subpackage Network
 */
class Stream implements \Genesis\Interfaces\Network
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
        return (int)substr($this->response, 9, 3);
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
     *
     * @param array $requestData
     *
     * @return void
     */
    public function prepareRequestBody($requestData)
    {
        $url = parse_url($requestData['url']);

        $headers = array(
            'Content-Type: text/xml',
            sprintf('Authorization: Basic %s', base64_encode($requestData['user_login'])),
            sprintf('Content-Length: %s', strlen($requestData['body'])),
            sprintf('User-Agent: %s', $requestData['user_agent']),
        );

        $contextOptions = array(
            'http' => array(
                'method'  => $requestData['type'],
                'header'  => implode("\r\n", $headers),
                'content' => $requestData['body'],
                'timeout' => $requestData['timeout']
            ),
            'ssl'  => array(
                // DO NOT allow self-signed certificates
                'allow_self_signed' => false,
                // Path to certificate/s PEM files used to validate the server authenticity
                'cafile'            => $requestData['ca_bundle'],
                // Validate Certificates
                'verify_peer'       => true,
                // Abort if the certificate-chain is longer than 5 nodes
                'verify_depth'      => 10,
                // SNI causes errors due to improper handling of alerts by OpenSSL in 0.9.8
                // As many php releases are linked against 0.9.8, its better to disable SNI
                // in case you can't upgrade.
                'SNI_enabled'       => true,
                // You can tweak the accepted Cipher list (if needed)
                'ciphers'           => implode(':', self::getCiphers())
            )
        );

        // Note: Mitigate CRIME/BEAST attacks
        if (\Genesis\Utils\Common::compareVersions('5.4.13', '>=')) {
            $contextOptions['ssl']['disable_compression'] = true;
        }

        // Note: PHP does NOT support SAN certs on PHP version < 5.6
        if (\Genesis\Utils\Common::compareVersions('5.6.0', '<')) {
            $contextOptions['ssl']['CN_match']          = $url['host'];
            $contextOptions['ssl']['SNI_server_name']   = $url['host'];
        } else {
            $contextOptions['ssl']['peer_name']         = $url['host'];
            $contextOptions['ssl']['verify_peer_name']  = true;
        }

        $this->streamContext = stream_context_create($contextOptions);

        $this->requestData = $requestData;
    }

    /**
     * Send the request
     *
     * @return void
     */
    public function execute()
    {
        set_error_handler(array($this, 'processErrors'), E_WARNING);

        $stream = fopen($this->requestData['url'], 'r', false, $this->streamContext);

        $this->responseBody = stream_get_contents($stream);

        $this->responseHeaders = $http_response_header;

        $this->response = implode("\r\n", $http_response_header) . "\r\n\r\n" . $this->responseBody;

        restore_error_handler();
    }

    /**
     * Handle stream-related errors
     *
     * @param $errNo  - error code
     * @param $errStr - error message
     *
     * @throws \Genesis\Exceptions\ErrorNetwork
     */
    public static function processErrors($errNo, $errStr)
    {
        // When an exception is being thrown, we have to restore
        // the handler.
        restore_error_handler();

        throw new \Genesis\Exceptions\ErrorNetwork($errStr, $errNo);
    }

    /**
     * Grab an array of Cipher definitions
     *
     * @return array
     */
    public static function getCiphers()
    {
        return array(
            'ECDHE-RSA-AES128-GCM-SHA256',
            'ECDHE-ECDSA-AES128-GCM-SHA256',
            'ECDHE-RSA-AES256-GCM-SHA384',
            'ECDHE-ECDSA-AES256-GCM-SHA384',
            'DHE-RSA-AES128-GCM-SHA256',
            'DHE-DSS-AES128-GCM-SHA256',
            'kEDH+AESGCM',
            'ECDHE-RSA-AES128-SHA256',
            'ECDHE-ECDSA-AES128-SHA256',
            'ECDHE-RSA-AES128-SHA',
            'ECDHE-ECDSA-AES128-SHA',
            'ECDHE-RSA-AES256-SHA384',
            'ECDHE-ECDSA-AES256-SHA384',
            'ECDHE-RSA-AES256-SHA',
            'ECDHE-ECDSA-AES256-SHA',
            'DHE-RSA-AES128-SHA256',
            'DHE-RSA-AES128-SHA',
            'DHE-DSS-AES128-SHA256',
            'DHE-RSA-AES256-SHA256',
            'DHE-DSS-AES256-SHA',
            'DHE-RSA-AES256-SHA',
            '!aNULL',
            '!eNULL',
            '!EXPORT',
            '!DES',
            '!3DES',
            '!MD5',
            '!RC4',
            '!PSK',
            '!SSLv2',
            '!SSLv3'
        );
    }
}
