<?php
/**
 * Network Requests Handler
 *
 * @package Genesis
 * @subpackage Network
 */

namespace Genesis\Network;

use \Genesis\Exceptions as Exceptions;
use \Genesis\API\Request as APIRequest;
use \Genesis\GenesisConfig as GenesisConfig;

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

    public function __construct(APIRequest $apiContext)
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
            'timeout'       => 60,
            'cert_ca'       => GenesisConfig::getCertificateAuthority(),
            'user_agent'    => sprintf('Genesis PHP Client v%s', GenesisConfig::getVersion()),
            'user_login'    => sprintf('%s:%s', GenesisConfig::getUsername(), GenesisConfig::getPassword()),
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
