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
 * Network Requests Handler
 *
 * @package Genesis
 * @subpackage Network
 */
class Request
{
    /**
     * Store instance of the API Request
     *
     * @var \Genesis\API\Request
     */
    private $apiContext;

    /**
     * Instance of the selected network wrapper
     * @var object
     */
    private $context;

    public function __construct(\Genesis\API\Request $apiContext)
    {
        $this->apiContext = $apiContext;

        $interface = \Genesis\GenesisConfig::getInterfaceSetup('network');

        switch ($interface) {
            default:
            case 'curl':
                $this->context = new Wrapper\cURL();
                break;
            case 'stream_context';
                $this->context = new Wrapper\StreamContext();
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
     */
    public function setRequestData()
    {
        $requestData = array(
            'body'          => $this->apiContext->getDocument(),
            'url'           => $this->apiContext->getApiConfig('url'),
            'type'          => $this->apiContext->getApiConfig('type'),
            'port'          => $this->apiContext->getApiConfig('port'),
            'protocol'      => $this->apiContext->getApiConfig('protocol'),
            'timeout'       => \Genesis\GenesisConfig::getNetworkTimeout(),
            'ca_bundle'     => \Genesis\GenesisConfig::getCertificateBundle(),
            'user_agent'    => sprintf('Genesis PHP Client v%s', \Genesis\GenesisConfig::getVersion()),
            'user_login'    => sprintf('%s:%s', \Genesis\GenesisConfig::getUsername(), \Genesis\GenesisConfig::getPassword()),
        );

        $this->context->prepareRequestBody($requestData);
    }

    /**
     * Submit the prepared request to Genesis
     */
    public function sendRequest()
    {
        $this->context->execute();
    }
}
