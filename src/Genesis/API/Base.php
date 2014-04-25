<?php

namespace Genesis\API;

use \Genesis\Base as GenesisBase;
use \Genesis\Exceptions as Exceptions;
use \Genesis\Configuration as Configuration;
use \Genesis\Utils\Builders as Builders;
use \Genesis\Network as Network;

abstract class Base
{
    /**
     * Store Request's configuration, like URL, Request Type, Transport Layer
     *
     * @var \ArrayObject
     */
    public $config;

    /**
     * Store the Request's Tree structure
     *
     * @var \ArrayObject
     */
    protected $treeStructure;

    /**
     * Store the names of the fields that are Required
     *
     * @var \ArrayObject
     */
    protected $requiredFields;

    /**
     * Store the names of "conditionally" Required fields.
     *
     * @var \ArrayObject
     */
    protected $requiredFieldsConditional;

    protected $xmlDocument;

    protected $httpRequest;

    public function __call($method, $args)
    {
        $requestedKey = strtolower(GenesisBase::uppercaseToUnderscore(substr($method, 3)));

        switch (substr($method, 0, 3)) {
            case 'add' :
                if (is_array($this->$requestedKey)) {
                    $arr = $this->$requestedKey;
                }
                else {
                    $arr = array();
                }

                array_push($arr, array($requestedKey => trim(reset($args))));
                $this->$requestedKey = $arr;
                break;
            case 'get' :
                return $this->config->offsetGet($requestedKey);
                break;
            case 'set' :
                $this->$requestedKey = trim(reset($args));
                break;
        }

        return null;
    }

    public function __get($property)
    {
        if (property_exists($this, $property))
        {
            return $this->$property;
        }

        return false;
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property))
        {
            $this->$property = $value;
        }

        return $this;
    }

    /**
     * Get the generated XML document
     *
     * @return mixed
     */
    public function getXMLDocument()
    {
        return $this->xmlDocument;
    }

    /**
     * Get the response from Genesis
     *
     * @return mixed String
     */
    public function getGenesisResponse()
    {
        return $this->httpRequest->responseBody;
    }

    /**
     * Finalize the request (meaning you can't set variables anymore)
     * and build the XML Markup
     */
    public function generateXML()
    {
        $this->finalizeRequest();

        $xmlDocument = new Builders\XMLWriter();
        $xmlDocument->populateXMLNodes($this->getRequestStructure());
        $this->xmlDocument = $xmlDocument->getOutput();
    }

    /**
     * Submit the generated XML Markup to Genesis
     */
    public function submitRequest()
    {
        $this->generateXML();

        $this->httpRequest = new Network\Request();
        $this->httpRequest->setRequestData($this);
        $this->httpRequest->submitToGenesis();
    }

    /**
     * Get array that represents the Tree structure in the XML Request
     *
     * @return array (API_Request_Fields)
     */
    public function getRequestStructure()
    {
        return $this->treeStructure->getArrayCopy();
    }

    /**
     * Rebuild, Sanitize and Verify Fields of the Tree structure
     */
    public function finalizeRequest()
    {
        $this->mapToTreeStructure();
        $this->sanitizeTreeStructure();
        $this->verifyRequirements();
    }

    /**
     * Create ArrayObject ($target) from passed Array ($source_array)
     *
     * @param $target - variable storing the instance of this object
     * @param $source_array - input array
     */
    protected function createArrayObject($target, $source_array)
    {
        $this->$target = new \ArrayObject($source_array, \ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * Build and set the correct URL for the request
     *
     * @param $gateway String
     * @param $path String
     * @param $token Bool
     */
    protected function setRequestURL($gateway, $path, $token)
    {
        $this->config->url = $this->buildRequestURL($gateway, $path, $token);
    }

    /**
     * Build the complete URL for the request
     *
     * @param $sub_domain String    - gateway/wpf etc.
     * @param $path String          - path of the current request
     * @param $appendToken Bool     - should we append the token to the end of the url
     * @return string               - complete URL (sub_domain,path,token)
     */
    protected function buildRequestURL($sub_domain = 'gateway', $path = '/', $appendToken = true)
    {
        $token      = Configuration::getToken();
        $base_url   = Configuration::getEnvironmentURL($this->config->protocol, $sub_domain, $this->config->port);

        if ($appendToken) {
            $url = sprintf('%s/%s/%s', $base_url, $path, $token);
        }
        else {
            $url = sprintf('%s/%s', $base_url, $path);
        }

        return $url;
    }

    /**
     * Remove empty keys/values from the structure
     */
    protected function sanitizeTreeStructure()
    {
        $arrayObject = $this->treeStructure->getArrayCopy();

        $arrayObject = GenesisBase::emptyValueRecursiveRemoval($arrayObject);

        $this->treeStructure->exchangeArray($arrayObject);
    }

    /**
     * Perform field validation
     */
    protected function verifyRequirements()
    {
        if ($this->requiredFields)
        {
            $this->requiredFields->setIteratorClass('RecursiveArrayIterator');

            $iterator = new \RecursiveIteratorIterator($this->requiredFields->getIterator());

            foreach($iterator as $fieldName)
            {
                if (empty($this->$fieldName)) {
                    throw new Exceptions\BlankRequiredField($fieldName);
                }
            }
        }

        if ($this->requiredFieldsConditional)
        {
            $fields = $this->requiredFieldsConditional->getArrayCopy();

            foreach($fields as $fieldName => $fieldDependencies)
            {
                if (isset($this->$fieldName)) {
                    foreach ($fieldDependencies as $field)
                    {
                        if (empty($this->$field)) {
                            throw new Exceptions\BlankRequiredField($fieldName . ' is depending on field: ' . $field);
                        }
                    }
                }
            }
        }
    }
}
