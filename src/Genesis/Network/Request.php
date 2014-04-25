<?php

namespace Genesis\Network;

use \Genesis\Exceptions as Exceptions;
use \Genesis\Configuration as Configuration;

class Request
{
    public $responseBody;
    public $responseStatus;

    private $wrapperContext;

    public function __construct()
    {
        if (function_exists('curl_version')) {
            $this->wrapperContext = new Wrapper\cURL();
        }
        else {
            $this->wrapperContext = new Wrapper\StreamContext();
            //throw new Exceptions\MissingComponent('cURL Library');
        }
    }

    /**
     * Get Genesis Response to a previously sent request
     */
    public function getGenesisResponse()
    {
        return $this->wrapperContext->getResponse();
    }

    /**
     * Set Header/Body of the HTTP request
     *
     * @param $request \Genesis\API\Request
     */
    public function setRequestData($request)
    {
        $requestData = array(
            'url'           => $request->getUrl(),
            'transport_url' => str_replace($request->getProtocol(), $request->getTransport(), $request->getUrl()),
            'body'          => $request->getXMLDocument(),
            'type'          => $request->getType(),
            'port'          => $request->getPort(),
            'protocol'      => $request->getProtocol(),
            'debug'         => Configuration::getDebug(),
            'cert_ca'       => Configuration::getCertificateAuthority(),
            'timeout'       => 60,
            'user_agent'    => sprintf('Genesis PHP Client v%s', Configuration::getVersion()),
            'user_login'    => sprintf('%s:%s', Configuration::getUsername(), Configuration::getPassword()),
        );

        $this->wrapperContext->prepareRequestBody($requestData);
    }

    /**
     * Submit the prepared request to Genesis
     */
    public function submitToGenesis()
    {
        $this->wrapperContext->submitRequest();

        $this->responseBody     = $this->wrapperContext->getResponse();
        $this->responseStatus   = $this->wrapperContext->getStatus();
    }
}
