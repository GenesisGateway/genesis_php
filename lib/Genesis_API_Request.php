<?php

namespace Genesis;

class Genesis_API_Request extends Genesis_Base
{
    private $_body;
    private $_context;
    private $_network;

    public function __call($method, $args) {
        $EtterType = substr($method, 0, 3);
        $ConfigKey = strtolower(parent::uppercaseToUnderscore(substr($method, 3)));

        switch ($EtterType) {
            case 'get' :
                break;
            case 'set' :
                $ConfigValue = trim($args[0]);

                $this->_context->setRequestData($ConfigKey, $ConfigValue);
                break;
            default :
                throw new Genesis_Exception_Invalid_Method();
        }
    }

    /**
     * Instantiate and initialize the selected request
     *
     * @param $request - name of the API request
     */
    public function loadRequest($request)
    {
        $request_class = sprintf('\Genesis\API_Request_%s', $request);
        $this->_context = new $request_class;
    }

    /**
     * Boolean flag for the Requests Transport Layer
     *
     * @return bool - true if it is SSL/TLS, false if anything else
     */
    public function isSecure()
    {
        return (bool)$this->_context->getRequestConfigKey('isSecure');
    }

    /**
     * Get the type of Request (currently only the type of HTTP Request: GET/POST/PUT)
     *
     * @return $string Request_type
     */
    public function getType()
    {
        return $this->_context->getRequestConfigKey('requestType');
    }

    /**
     * Check if the Request's Body is not empty
     *
     * @return bool - true if the body of the request is not empty, false if it is
     */
    public function isNotEmpty()
    {
        if (empty($this->_body))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Build the URL for the current request.
     *
     * @return string
     */
    public function buildURL()
    {
        return sprintf("%s/%s/%s",
            Genesis_Configuration::getEnviormentURL(),
            $this->_context->getRequestConfigKey('url'),
            Genesis_Configuration::getToken()
        );
    }

    /**
     * Set a parameter for the selected request
     *
     * @param $key      - name of the parameter
     * @param $value    - value of the parameter
     */
    public function setParameter($key, $value)
    {
        $this->_context->$key = $value;
    }

    /*
     * Proxy function to the request's validation
     * function for verifying if all fields are
     * filled correctly
     *
     * @return bool
     */
    public function validateRequirements()
    {
        return $this->_context->isRequiredFilled();
    }

    public function getBody()
    {
        return $this->_body;
    }

    /**
     * Generate the full XML Markup for the request
     * after we ensure that all mandatory fields
     * are filled
     *
     * @throws Genesis_Required_Fields_Are_Empty
     */
    public function generateXML()
    {
        if ( !$this->validateRequirements() )
        {
            throw new Genesis_Exception_Required_Fields_Are_Empty();
        }

        $xmlDocument = new \Genesis\Genesis_Builder_XML();
        $xmlDocument->generateBody($this->_context->getArrayStructure());
        $this->_body = $xmlDocument->getOutput();
    }

    /**
     * Initialize the network layer and submit the data
     * to Genesis Gateway
     */
    public function submitRequest()
    {
        $this->generateXML();

        $this->_network = new \Genesis\Genesis_HTTP_Request();
        $this->_network->setRequest($this);
        $this->_network->submitToGenesis();
    }

}