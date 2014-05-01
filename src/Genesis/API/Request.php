<?php

namespace Genesis\API;

use \Genesis\Base as Base;
use \Genesis\Network as Network;
use \Genesis\Builders as Builders;
use \Genesis\Exceptions as Exceptions;
use \Genesis\Configuration as Configuration;

abstract class Request
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

    /**
     * Store group name/fields where at least on the fields
     * is required
     *
     * @var \ArrayObject
     */
    protected $requiredFieldsGroups;

    /**
     * Store the generated XML Body
     *
     * @var String
     */
    protected $requestDocument;

    /**
     * Store the Network Request Handle
     * @var \Genesis\Network\Request
     */
    protected $networkRequest;

    public function __call($method, $args)
    {
        $methodType     = substr($method, 0, 3);
        $requestedKey   = strtolower(Base::uppercaseToUnderscore(substr($method, 3)));

        switch ($methodType) {
            case 'add' :
                if (isset($this->$requestedKey) && is_array($this->$requestedKey)) {
                    $arr = $this->$requestedKey;
                }
                else {
                    $arr = array();
                }

                array_push($arr, array($requestedKey => trim(reset($args))));
                $this->$requestedKey = $arr;
                break;
            case 'set' :
                $this->$requestedKey = trim(reset($args));
                break;
            case 'get' :
                return $this->config->offsetGet($requestedKey);
                break;
        }

        return null;
    }

    public function getRequestParameter($parameter)
    {
        $this->populateStructure();
        return $this->$parameter;
    }

    /**
     * Get the generated document
     *
     * @return mixed
     */
    public function getRequestDocument()
    {
        return $this->requestDocument;
    }

    /**
     * Get response from Genesis
     *
     * @return mixed String
     */
    public function getGenesisResponse()
    {
        return $this->networkRequest->getResponseBody();
    }

    /**
     * Get associative array that represents the tree-structure of the request
     *
     * @return array (API_Request_Fields)
     */
    public function getRequestStructure()
    {
        return $this->treeStructure->getArrayCopy();
    }

    /**
     * Build the request in the specified format
     */
    public function Build()
    {
        if (empty($this->treeStructure)) {
            $this->Prepare();
        }

        switch($this->config->offsetGet('format')) {
            default:
            case 'xml':
                $builder = new Builders\XML();
                break;
        }

        $builder->parseStructure($this->getRequestStructure());
        $this->requestDocument = $builder->getDocument();
    }

    /**
     * Submit the request document to Genesis
     */
    public function Send()
    {
        $this->Prepare();
        $this->Build();
        $this->SendToGenesis();
    }

    /**
     * Rebuild, Sanitize and Verify Fields of the tree-structure
     */
    protected function Prepare()
    {
        $this->populateStructure();
        $this->sanitizeStructure();
        $this->checkRequirements();
    }

    /**
     * Initialize network and send the produced document
     */
    protected function SendToGenesis()
    {
        $this->networkRequest = new Network\Request();
        $this->networkRequest->setRequestData($this);
        $this->networkRequest->submitToGenesis();
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
    protected function sanitizeStructure()
    {
        $arrayObject = $this->treeStructure->getArrayCopy();

        $arrayObject = Base::emptyValueRecursiveRemoval($arrayObject);

        $this->treeStructure->exchangeArray($arrayObject);
    }

    /**
     * Perform field validation
     */
    protected function checkRequirements()
    {
        if (isset($this->requiredFields)) {
            $this->requiredFields->setIteratorClass('RecursiveArrayIterator');

            $iterator = new \RecursiveIteratorIterator($this->requiredFields->getIterator());

            foreach($iterator as $fieldName)
            {
                if (empty($this->$fieldName)) {
                    throw new Exceptions\BlankRequiredField($fieldName, 0);
                }
            }
        }

        if (isset($this->requiredFieldsGroups)) {
            $fields = $this->requiredFieldsGroups->getArrayCopy();

            $emptyFlag = false;
            $groupsFormatted = array();

            foreach($fields as $group => $groupFields)
            {
                $groupsFormatted[] = sprintf('%s (%s)', ucfirst($group), implode(', ', $groupFields));

                foreach ($groupFields as $field)
                {
                    if (!empty($this->$field)) {
                        $emptyFlag = true;
                    }
                }
            }

            if (!$emptyFlag) {
                throw new Exceptions\BlankRequiredField('One of the following groups of fields: ' . implode(' / ', $groupsFormatted) . ' must be filled in!', 1);
            }
        }

        if (isset($this->requiredFieldsConditional)) {
            $fields = $this->requiredFieldsConditional->getArrayCopy();

            foreach($fields as $fieldName => $fieldDependencies)
            {
                if (isset($this->$fieldName)) {
                    foreach ($fieldDependencies as $field)
                    {
                        if (empty($this->$field)) {
                            throw new Exceptions\BlankRequiredField($fieldName . ' is depending on field: ' . $field, 0);
                        }
                    }
                }
            }
        }
    }
}
