<?php

namespace Genesis;


abstract class Genesis_API_Request_Base extends Genesis_Base
{
    /**
     * Tree structure of the API Request
     *
     * Note: This is the structure we use
     * in order to create the XML request
     *
     * @var $_fieldStructure
     */
    protected $fieldStructure;
    /**
     * Array holding the names of the fields
     * that are Mandatory
     *
     * @var $_fieldMandatory
     */
    protected $fieldMandatory;

    /**
     * Store "per_request" configuration, like
     * isPost, isSecure, URL etc.
     *
     * @var $requestConfig
     */
    protected $requestConfig;

    /**
     * Since we're using anonymous functions
     * and callbacks, we need this variable
     * to hold our data
     *
     * @var $_lastSetData
     */
    private $_scope;

    public function getRequestConfigKey($key)
    {
        if ( isset($this->requestConfig[$key]))
        {
            return $this->requestConfig[$key];
        }
    }

    /**
     * Get the structure array that represents the
     * Hierarchy tree structure of the request
     *
     * @return array (API_Request_Fields)
     */
    public function getArrayStructure()
    {
        return $this->fieldStructure;
    }

    /**
     * Set the parameter key/value pair in our XML
     * structure
     *
     * @param $setKey   - the parameter key
     * @param $setValue - the parameter value
     */
    public function setRequestData($setKey, $setValue)
    {
        $this->_scope['parameter'] = array ('key' => $setKey, 'value' => $setValue);

        array_walk_recursive($this->fieldStructure, function (&$value, $key)
        {
            if (strval($key) == strval($this->_scope['parameter']['key'])) {
                $value = $this->_scope['parameter']['value'];
            }
        });
    }

    /**
     * Check, whether or not all mandatory fields are
     * filled before submitting
     *
     * @return bool
     */
    public function isRequiredFilled()
    {
        $this->_scope['mandatory']['field']     = null;
        $this->_scope['mandatory']['status']    = true;

        foreach ($this->fieldMandatory as $mandatoryField)
        {
            $this->_scope['mandatory']['field'] = $mandatoryField;

            array_walk_recursive($this->fieldStructure, function($value, $key)
            {
                if (strval($key) == strval($this->_scope['mandatory']['field'])) {
                    if (empty($value)) {
                        $this->_scope['mandatory']['status'] = false;
                    }
                }
            });
        }

        return $this->_scope['mandatory']['status'];
    }
} 