<?php
/**
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
 * @author      emerchantpay
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
namespace Genesis;

/**
 * Network Requests Handler
 *
 * @package    Genesis
 * @subpackage Network
 */
class Network
{
    /**
     * Instance of the selected network wrapper
     *
     * @var mixed
     */
    private $context;

    /**
     * Initialize the Network instance with API Request instance
     *
     * @param string $interface
     */
    public function __construct($interface = null)
    {
        $interface = $interface ?: \Genesis\Config::getInterface('network');

        switch ($interface) {
            default:
            case 'curl':
                $this->context = new Network\cURL();
                break;
            case 'stream':
                $this->context = new Network\Stream();
                break;
        }
    }

    /**
     * Get Genesis Response to a previously sent request
     *
     * @return mixed
     */
    public function getGenesisResponse()
    {
        return $this->context->getResponse();
    }

    /**
     * Get the Body of the response
     *
     * @return mixed
     */
    public function getResponseBody()
    {
        return $this->context->getResponseBody();
    }

    /**
     * Get the Headers of the response
     *
     * @return mixed
     */
    public function getResponseHeaders()
    {
        return $this->context->getResponseHeaders();
    }

    /**
     * Set Header/Body of the HTTP request
     *
     * @param \Genesis\API\Request $apiContext
     * @throws Exceptions\ErrorParameter
     * @throws Exceptions\InvalidArgument
     * @throws Exceptions\InvalidClassMethod
     */
    public function setApiCtxData($apiContext)
    {
        $this->context->prepareRequestBody(
            [
                'body'       => $apiContext->getDocument(),
                'url'        => $apiContext->getApiConfig('url'),
                'type'       => $apiContext->getApiConfig('type'),
                'port'       => $apiContext->getApiConfig('port'),
                'protocol'   => $apiContext->getApiConfig('protocol'),
                'format'     => $apiContext->getApiConfig('format'),
                'timeout'    => \Genesis\Config::getNetworkTimeout(),
                'user_agent' => sprintf('Genesis PHP Client v%s', \Genesis\Config::getVersion()),
                'user_login' => sprintf('%s:%s', \Genesis\Config::getUsername(), \Genesis\Config::getPassword())
            ]
        );
    }

    /**
     * Submit the prepared request to Genesis
     */
    public function sendRequest()
    {
        $this->context->execute();
    }
}
