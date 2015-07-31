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
 * cURL Network Interface
 * Note: requires php curl extension
 *
 * @package    Genesis
 * @subpackage Network
 */
// @codingStandardsIgnoreStart
class cURL implements \Genesis\Interfaces\Network
// @codingStandardsIgnoreEnd
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

    /**
     * Initialize cURL
     */
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
        return (int)curl_getinfo($this->curlHandle, CURLINFO_HTTP_CODE);
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
     * @param array $requestData
     *
     * @return void
     */
    public function prepareRequestBody($requestData)
    {
        $options = array(
            CURLOPT_URL            => $requestData['url'],
            CURLOPT_TIMEOUT        => $requestData['timeout'],
            CURLOPT_USERAGENT      => $requestData['user_agent'],
            CURLOPT_USERPWD        => $requestData['user_login'],
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_ENCODING       => 'gzip',
            CURLOPT_HTTPHEADER     => array(
                'Content-Type: text/xml',
                // Workaround to prevent cURL from parsing HTTP 100 as separate request
                'Expect:'
            ),
            CURLOPT_HEADER         => true,
            CURLOPT_FAILONERROR    => true,
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_RETURNTRANSFER => true,
            // SSL/TLS Configuration
            CURLOPT_CAINFO         => $requestData['ca_bundle'],
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        );

        if ('POST' == strtoupper($requestData['type'])) {
            $post = array(
                CURLOPT_POST       => true,
                CURLOPT_POSTFIELDS => $requestData['body']
            );

            $options = $options + $post;
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
     * @throws \Genesis\Exceptions\ErrorNetwork
     */
    public function checkForErrors()
    {
        $errNo  = curl_errno($this->curlHandle);
        $errStr = curl_error($this->curlHandle);

        if ($errNo > 0) {
            throw new \Genesis\Exceptions\ErrorNetwork($errStr, $errNo);
        }
    }
}
