<?php

namespace Genesis;

class Genesis_API_Request extends Genesis_Base
{
    /**
     * Placeholder for the HTTP_Request instance
     * @var $httpRequest
     */
    private $httpRequest;
    /**
     * Placeholder for the API_Request instance
     * @var $requestContext
     */
    private $requestContext;
    /**
     * Placeholder for the generated XML Document
     * @var $xmlDocument
     */
    private $xmlDocument;

    /**
     * Initialize and instantiate the desired request
     *
     * @param $request - name of the API request
     */
    public function loadRequest($request)
    {
        $request_class = sprintf('\Genesis\API_Request_%s', $request);
        $this->requestContext = new $request_class;
    }

    /**
     * Redirect get/set requests from this instance to the Request Context
     *
     * @param $method
     * @param $args
     * @throws Genesis_Exception_Invalid_Method
     */
    public function __call($method, $args)
    {
        $requestedKey = strtolower(parent::uppercaseToUnderscore(substr($method, 3)));

        switch (substr($method, 0, 3)) {
            case 'add' :
                if (is_array($this->requestContext->$requestedKey)) {
                    $arr = $this->requestContext->$requestedKey;
                } else {
                    $arr = array();
                }

                array_push($arr, array($requestedKey => trim(reset($args))));

                $this->requestContext->$requestedKey = $arr;
                break;
            case 'get' :
                return $this->requestContext->config->offsetGet($requestedKey);
                break;
            case 'set' :
                $this->requestContext->$requestedKey = trim(reset($args));
                break;
            default :
                throw new Genesis_Exception_Invalid_Method();
        }
    }

    /**
     * Get the generated XML document
     * @return mixed
     */
    public function getXMLDocument()
    {
        return $this->xmlDocument;
    }

    /**
     * Generate the full XML Markup for the request
     * after we ensure that all mandatory fields
     * are filled
     *
     */
    public function generateXML()
    {
        $this->requestContext->finalizeRequest();

        //var_dump($this->requestContext->getRequestStructure());
        //exit;

        $xmlDocument = new Genesis_Builder_XML();
        $xmlDocument->populateXMLNodes($this->requestContext->getRequestStructure());
        $xmlDocument->finishDocument();
        $this->xmlDocument = $xmlDocument->getOutput();
    }

    /**
     * Initialize the network layer and submit the data
     * to Genesis Gateway
     */
    public function submitRequest()
    {
        $this->generateXML();

        $this->httpRequest = new Genesis_HTTP_Request();
        $this->httpRequest->setRequestData($this);
        $this->httpRequest->submitToGenesis();

        var_dump($this->httpRequest->responseBody);
    }

}