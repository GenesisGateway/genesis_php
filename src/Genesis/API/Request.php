<?php
/**
 * Request Genesis
 * This is the base of every API request
 *
 * @package Genesis
 * @subpackage API
 */

namespace Genesis\API;

use \Genesis\Network as Network;
use \Genesis\Builders as Builders;
use \Genesis\Exceptions as Exceptions;
use \Genesis\GenesisConfig as GenesisConfig;
use \Genesis\Utils\Common as Common;
use \Genesis\Utils\Currency as Currency;

abstract class Request
{
    /**
     * Store Request's configuration, like URL, Request Type, Transport Layer
     *
     * @var \ArrayObject
     */
    public $config;

    /**
     * Store the API Response context
     * s
     * @var \Genesis\API\Response
     */
    public $response;

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

        return $this;
    }

    /**
     * Generate the XML output
     *
     * @return string - XML Document with request data
     */
    public function getDocument()
    {
        $this->processRequestParameters();

        $this->builderContext = new Builders\Builder();
        $this->builderContext->parseStructure($this->treeStructure->getArrayCopy());

        return $this->builderContext->getDocument();
    }

    /**
     * Getter for per-request GenesisConfig
     *
     * @param $key - setting name
     *
     * @return mixed - contents of the specified setting
     */
    public function getApiConfig($key)
    {
        return $this->config->offsetGet($key);
    }

    /**
     * Setter for per-request GenesisConfig
     *
     * @param $key      - setting name
     * @param $value    - setting value
     *
     * @return void
     */
    protected function setApiConfig($key, $value)
    {
        $this->config->offsetSet($key, $value);
    }

    /**
     * Build the complete URL for the request
     *
     * @param $sub_domain String    - gateway/wpf etc.
     * @param $path String          - path of the current request
     * @param $appendToken Bool     - should we append the token to the end of the url
     *
     * @return string               - complete URL (sub_domain,path,token)
     */
    protected function buildRequestURL($sub_domain = 'gateway', $path = '/', $appendToken = true)
    {
        $base_url = GenesisConfig::getEnvironmentURL($this->config->protocol, $sub_domain, $this->config->port);

        $token = $appendToken ? GenesisConfig::getToken() : '';

        return sprintf('%s/%s/%s', $base_url, $path, $token);
    }

    /**
     * Process Everything the variables set previously
     *
     * Step 1: Execute per-field actions
     * Step 2: Update the Tree structure
     * Step 3: Clean the empty leafs
     * Step 4: Check for Required Fields
     *
     * @return void
     */
    protected function processRequestParameters()
    {
        // Step 1
        $this->processAmount();
        // Step 2
        $this->populateStructure();
        // Step 3
        $this->sanitizeStructure();
        // Step 4
        $this->checkRequirements();
    }

    /**
     * Remove empty keys/values from the structure
     *
     * @return void
     */
    protected function sanitizeStructure()
    {
        $this->treeStructure->exchangeArray(Common::emptyValueRecursiveRemoval($this->treeStructure->getArrayCopy()));
    }

    /**
     * Perform field validation
     *
     * @throws Exceptions\BlankRequiredField
     * @return void
     */
    protected function checkRequirements()
    {
        /* Verify that all required fields are populated */
        if (isset($this->requiredFields)) {
            $this->requiredFields->setIteratorClass('RecursiveArrayIterator');

            $iterator = new \RecursiveIteratorIterator($this->requiredFields->getIterator());

            foreach($iterator as $fieldName)
            {
                if (empty($this->$fieldName)) {
                    throw new Exceptions\BlankRequiredField($fieldName);
                }
            }
        }

        /* Verify that the group fields in the request are populated */
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
                throw new Exceptions\BlankRequiredField('One of the following group(s) of field(s): ' . implode(' / ', $groupsFormatted) . ' must be filled in!', true);
            }
        }

        /* Verify that all fields (who depend on previously populated fields) are populated */
        if (isset($this->requiredFieldsConditional)) {
            $fields = $this->requiredFieldsConditional->getArrayCopy();

            foreach($fields as $fieldName => $fieldDependencies)
            {
                if (isset($this->$fieldName) && !empty($this->$fieldName)) {
                    foreach ($fieldDependencies as $field)
                    {
                        if (empty($this->$field)) {
                            throw new Exceptions\BlankRequiredField($fieldName . ' is depending on field: ' . $field . ' which');
                        }
                    }
                }
            }
        }

        /* Verify conditional requirement, where either one of the fields are populated */
        if (isset($this->requiredFieldsOR)) {
            $fields = $this->requiredFieldsOR->getArrayCopy();

            $status = false;

            foreach ($fields as $fieldName)
            {
                if (isset($this->$fieldName) && !empty($this->$fieldName)) {
                    $status = true;
                }
            }

            if (!$status) {
                throw new Exceptions\BlankRequiredField(implode($fields));
            }
        }
    }

    /**
     * Process the amount set by user to comply with ISO-4217
     *
     * @return void
     */
    protected function processAmount()
    {
        if (isset($this->amount) && isset($this->currency)) {
            $this->amount = Currency::realToExponent($this->amount, $this->currency);
        }
    }
}