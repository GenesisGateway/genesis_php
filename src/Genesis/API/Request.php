<?php

namespace Genesis\API;

use \Genesis\Base as Base;
use \Genesis\Network as Network;
use \Genesis\Builders as Builders;
use \Genesis\Exceptions as Exceptions;
use \Genesis\Configuration as Configuration;
use Genesis\Utils\Common;

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
     * Store the generated Builder Body
     *
     * @var \Genesis\Builders\Builder
     */
    protected $builderContext;

    /**
     * Store the Network Request Handle
     *
     * @var \Genesis\Network\Request
     */
    protected $networkContext;

    /**
     * Store the API Response context
     * s
     * @var \Genesis\API\Response
     */
    public $response;

    public function __call($method, $args)
    {
        $methodType     = substr($method, 0, 3);
        $requestedKey   = strtolower(Common::uppercaseToUnderscore(substr($method, 3)));

        switch ($methodType) {
            case 'add' :
                if (isset($this->$requestedKey) && is_array($this->$requestedKey)) {
                    $groupArray = $this->$requestedKey;
                }
                else {
                    $groupArray = array();
                }

                array_push($groupArray, array($requestedKey => trim(reset($args))));
                $this->$requestedKey = $groupArray;
                break;
            case 'set' :
                $this->$requestedKey = trim(reset($args));
                break;
        }

        return null;
    }

    /**
     * Getter for per-request Configuration
     *
     * @param $key
     *
     * @return mixed
     */
    public function getApiConfig($key)
    {
        return $this->config->offsetGet($key);
    }

    /**
     * Setter for per-request Configuration
     *
     * Note: Its important for this to be protected
     *
     * @param $key
     * @param $value
     */
    protected function setApiConfig($key, $value)
    {
        $this->config->offsetSet($key, $value);
    }

    /**
     * Get the generated document
     *
     * @return mixed
     */
    public function getDocument()
    {
        if ( !$this->builderContext) {
            $this->populateStructure();
            $this->sanitizeStructure();
            $this->isRequirementsFulfilled();

            $this->builderContext = new Builders\Builder();
            $this->builderContext->parseStructure($this->treeStructure->getArrayCopy());
        }

        return $this->builderContext->getDocument();
    }

    /**
     * Get response from Genesis
     *
     * @return mixed String
     */
    public function getGenesisResponse()
    {
        return $this->networkContext->getResponseBody();
    }

    /**
     * Submit the request document to Genesis
     *
     * Steps:
     * 1) Build the tree structure from local variables
     * 2) Remove null nodes
     * 3) Check if all requirements for this request are filled
     * 4) Instantiate builder Context (XML, JSON etc.)
     * 5) Parse the tree structure
     * 6) Instantiate Network
     * 7) Set the request data
     * 8) Send the request to Genesis
     * 9) Parse the incoming response in a new instance of API\Response
     *
     */
    public function Send()
    {
        $this->networkContext = new Network\Request($this);
        $this->networkContext->setRequestData();
        $this->networkContext->sendRequest();

        Base::$Response = new Response($this->networkContext);
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
        $base_url = Configuration::getEnvironmentURL($this->config->protocol, $sub_domain, $this->config->port);

        if ($appendToken) {
            $url = sprintf('%s/%s/%s', $base_url, $path, Configuration::getToken());
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
        $this->treeStructure->exchangeArray(Common::emptyValueRecursiveRemoval($this->treeStructure->getArrayCopy()));
    }

    /**
     * Perform field validation
     */
    protected function isRequirementsFulfilled()
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
