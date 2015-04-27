<?php
/*
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
namespace Genesis\API;

/**
 * Class Request
 *
 * Base of every API request
 *
 * @package    Genesis
 * @subpackage API
 */
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
     * Store a OR relationship between fields, whether at
     * least of of them has to be filled in.
     *
     * @var \ArrayObject
     */
    protected $requiredFieldsOR;

    /**
     * Store the generated Builder Body
     *
     * @var \Genesis\Builder
     */
    protected $builderContext;

    /**
     * Bootstrap per-request configuration
     */
    public function __construct()
    {
        $this->initConfiguration();
        $this->setRequiredFields();
    }

    /**
     * Initialize per-request configuration
     */
    protected function initConfiguration()
    {

    }

    /**
     * Set the *required fields for the request
     */
    protected function setRequiredFields()
    {

    }

    /**
     * Convert Pascal to Camel case and set the correct property
     *
     * @param $method
     * @param $args
     *
     * @return $this
     */
    public function __call($method, $args)
    {
        $methodType = substr($method, 0, 3);
        $requestedKey = strtolower(\Genesis\Utils\Common::pascalToSnakeCase(substr($method, 3)));

        switch ($methodType) {
            case 'add':
                if (isset($this->$requestedKey) && is_array($this->$requestedKey)) {
                    $groupArray = $this->$requestedKey;
                } else {
                    $groupArray = array();
                }

                array_push($groupArray, array($requestedKey => trim(reset($args))));
                $this->$requestedKey = $groupArray;
                break;
            case 'set':
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

        $this->builderContext = new \Genesis\Builder();
        $this->builderContext->parseStructure($this->treeStructure->getArrayCopy());

        return $this->builderContext->getDocument();
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
        $this->populateStructure();
        // Step 2
        $this->sanitizeStructure();
        // Step 3
        $this->checkRequirements();
    }

    /**
     * Create the Tree structure and populate
     * the fields with the set parameters.
     */
    protected function populateStructure()
    {

    }

    /**
     * Remove empty keys/values from the structure
     *
     * @return void
     */
    protected function sanitizeStructure()
    {
        $this->treeStructure->exchangeArray(\Genesis\Utils\Common::emptyValueRecursiveRemoval($this->treeStructure->getArrayCopy()));
    }

    /**
     * Perform field validation
     *
     * @throws \Genesis\Exceptions\BlankRequiredField
     * @return void
     */
    protected function checkRequirements()
    {
        /* Verify that all required fields are populated */
        if (isset($this->requiredFields)) {
            $this->requiredFields->setIteratorClass('RecursiveArrayIterator');

            $iterator = new \RecursiveIteratorIterator($this->requiredFields->getIterator());

            foreach ($iterator as $fieldName) {
                if (empty($this->$fieldName)) {
                    throw new \Genesis\Exceptions\BlankRequiredField($fieldName);
                }
            }
        }

        /* Verify that the group fields in the request are populated */
        if (isset($this->requiredFieldsGroups)) {
            $fields = $this->requiredFieldsGroups->getArrayCopy();

            $emptyFlag = false;
            $groupsFormatted = array();

            foreach ($fields as $group => $groupFields) {
                $groupsFormatted[] = sprintf(
                    '%s (%s)',
                    ucfirst($group),
                    implode(', ', $groupFields)
                );

                foreach ($groupFields as $field) {
                    if (!empty($this->$field)) {
                        $emptyFlag = true;
                    }
                }
            }

            if (!$emptyFlag) {
                throw new \Genesis\Exceptions\BlankRequiredField(
                    'One of the following group(s) of field(s): ' . implode(' / ', $groupsFormatted) . ' must be filled in!',
                    true
                );
            }
        }

        /* Verify that all fields (who depend on previously populated fields) are populated */
        if (isset($this->requiredFieldsConditional)) {
            $fields = $this->requiredFieldsConditional->getArrayCopy();

            foreach ($fields as $fieldName => $fieldDependencies) {
                if (isset($this->$fieldName) && !empty($this->$fieldName)) {
                    foreach ($fieldDependencies as $field) {
                        if (empty($this->$field)) {
                            throw new \Genesis\Exceptions\BlankRequiredField(
                                $fieldName . ' is depending on field: ' . $field . ' which'
                            );
                        }
                    }
                }
            }
        }

        /* Verify conditional requirement, where either one of the fields are populated */
        if (isset($this->requiredFieldsOR)) {
            $fields = $this->requiredFieldsOR->getArrayCopy();

            $status = false;

            foreach ($fields as $fieldName) {
                if (isset($this->$fieldName) && !empty($this->$fieldName)) {
                    $status = true;
                }
            }

            if (!$status) {
                throw new \Genesis\Exceptions\BlankRequiredField(implode($fields));
            }
        }
    }

    /**
     * Add transaction type
     *
     * @param string $name
     * @param array     $parameters
     */
    public function addTransactionType($name, $parameters = array())
    {

    }

    /**
     * Set the language of a WPF form
     */
    public function setLanguage()
    {

    }

    /**
     * Perform a field transformation
     * and return the result
     *
     * @param string $method
     * @param array  $args
     * @param string $prefix
     *
     * @return mixed
     */
    protected function transform($method, $args, $prefix = 'transform')
    {
        $method = $prefix . \Genesis\Utils\Common::snakeCaseToCamelCase($method);

        if (method_exists($this, $method)) {
            $result = call_user_func_array(array($this, $method), $args);

            if ($result) {
                return $result;
            }
        }

        return reset($args);
    }

    /**
     * Convert the amount from Minor cur
     *
     * @param string $amount
     * @param string $currency
     *
     * @return string
     */
    protected function transformAmount($amount = '', $currency = '')
    {
        if (!empty($amount) && !empty($currency)) {
            return \Genesis\Utils\Currency::amountToExponent($amount, $currency);
        }

        return false;
    }

    /**
     * Setter for per-request Config
     *
     * @param $key   - setting name
     * @param $value - setting value
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
     * @param $sub_domain  String    - gateway/wpf etc.
     * @param $path        String          - path of the current request
     * @param $appendToken Bool     - should we append the token to the end of the url
     *
     * @return string               - complete URL (sub_domain,path,token)
     */
    protected function buildRequestURL($sub_domain = 'gateway', $path = '/', $appendToken = true)
    {
        $proto = isset($this->config) ? $this->getApiConfig('protocol') : '';
        $port = isset($this->config) ? $this->getApiConfig('port') : '';
        $token = ($appendToken) ? \Genesis\Config::getToken() : '';

        $base_url = \Genesis\Config::getEnvironmentURL($proto, $sub_domain, $port);

        return sprintf('%s/%s/%s', $base_url, $path, $token);
    }

    /**
     * Getter for per-request Config
     *
     * @param $key - setting name
     *
     * @return mixed - contents of the specified setting
     */
    public function getApiConfig($key)
    {
        return $this->config->offsetGet($key);
    }
}
