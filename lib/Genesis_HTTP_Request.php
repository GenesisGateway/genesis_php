<?php

namespace Genesis;


class Genesis_HTTP_Request extends Genesis_Base
{
    public $responseBody;
    public $responseStatus;

    private $wrapperContext;

    public function __construct()
    {
        if (function_exists('curl_version')) {
            $this->wrapperContext = new Genesis_HTTP_Request_cURL();
        } else {
            throw new Genesis_Exception_Missing_Component('cURL');
        }
    }

    public function setRequestData($request)
    {
        $requestData = array (
            'ssl'           => $request->getSsl(),
            'url'           => $request->getUrl(),
            'body'          => $request->getXMLDocument(),
            'type'          => $request->getType(),
            'debug'         => (bool)Genesis_Configuration::getDebug(),
            'cert_ca'       => Genesis_Configuration::getCertificateAuthority(),
            'user_agent'    => sprintf('Genesis PHP Client v%s', Genesis_Configuration::getVersion()),
            'user_login'    => sprintf('%s:%s', Genesis_Configuration::getUsername(), Genesis_Configuration::getPassword()),
        );

        $this->wrapperContext->prepareRequestBody($requestData);
    }

    /**
     * submitRequest the request
     *
     */
    public function submitToGenesis()
    {
        $this->wrapperContext->submitRequest();

        $this->responseBody     = $this->wrapperContext->getResponse();
        $this->responseStatus   = $this->wrapperContext->getStatus();
    }
}