<?php

namespace Genesis;


abstract class Genesis_API_Request_Base extends Genesis_Base
{
    /**
     * Store "per_request" configuration, like
     * isPost, isSecure, URL etc.
     *
     * @var $config
     */
    public $config;

    /**
     * Array representing the tree-structure of the Request
     *
     * @var $treeStructure
     */
    protected $treeStructure;

    /**
     * Array holding the names of the fields
     * that are Mandatory
     *
     * @var $requiredFields
     */
    protected $requiredFields;

    /**
     * Array holding the names of conditionally
     * required fields.
     *
     * @var $requiredFieldsConditional
     */
    protected $requiredFieldsConditional;


    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return false;
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }

    /**
     * Generate the URL for this Request
     *
     * @param string $sub_domain - gateway/wpf etc.
     * @param string $path - path of the current request
     * @return string - complete URL (sub_domain,path,token)
     */
    protected function getRequestURL($sub_domain = 'gateway', $path = '/')
    {
        $base_url   = Genesis_Configuration::getEnviormentURL($sub_domain);
        $token      = Genesis_Configuration::getToken();

        return sprintf('%s/%s/%s', $base_url, $path, $token);
    }

    /**
     * Get array that represents the Hierarchy
     * structure in the XML Request
     *
     * @return array (API_Request_Fields)
     */
    public function getRequestStructure()
    {
        return $this->treeStructure->getArrayCopy();
    }

    /**
     * Rebuild the Tree Structure of the Request
     */
    public function finalizeRequest()
    {
        $this->mapToTreeStructure();
        $this->sanitizeTreeStructure();
        $this->verifyRequirements();
    }

    /**
     * Helper function: create ArrayObject from array
     *
     * @param $target - variable storing the instance of this object
     * @param $source_array - input array
     */
    protected function createArrayObject($target, $source_array)
    {
        $this->$target = new \ArrayObject($source_array, \ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * Helper function: map the previously set data
     * to the tree structure representing the request
     *
     * @note this method must be overridden by the
     * specific request class
     */
    protected function mapToTreeStructure() { }

    /**
     * Helper function: Remove empty keys/values from the structure
     */
    protected function sanitizeTreeStructure()
    {
        $arrayObject = $this->treeStructure->getArrayCopy();

        $arrayObject = Genesis_Base::emptyValueRecursiveRemoval($arrayObject);

        $this->treeStructure->exchangeArray($arrayObject);
    }

    /**
     * Helper function: Perform field validation
     */
    protected function verifyRequirements()
    {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->requiredFields));

        foreach($iterator as $fieldName)
        {
            if (empty($this->$fieldName)) {
                throw new Genesis_Exception_Required_Fields_Are_Empty($fieldName);
            }
        }


        if ($this->requiredFieldsConditional)
        {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->requiredFieldsConditional));

            foreach($iterator as $fieldName => $fieldDependencies)
            {
                if (isset($this->$fieldName)) {
                    foreach ($fieldDependencies as $field)
                    {
                        if (empty($field)) {
                            throw new Genesis_Exception_Required_Fields_Are_Empty($field);
                        }
                    }
                }
            }
        }
    }
} 