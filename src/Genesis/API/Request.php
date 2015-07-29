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

        // A request might not always feature 'required' fields
        if (method_exists($this, 'setRequiredFields')) {
            $this->setRequiredFields();
        }
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
        list($action, $target) = \Genesis\Utils\Common::resolveDynamicMethod($method);

        switch ($action) {
            case 'get':
                if (property_exists($this, $target)) {
                    return $this->$target;
                }

                break;
            case 'set':
                if (property_exists($this, $target)) {
                    $this->$target = trim(reset($args));
                    return $this;
                }

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

        if ($this->treeStructure instanceof \ArrayObject) {
            $this->builderContext = new \Genesis\Builder();
            $this->builderContext->parseStructure($this->treeStructure->getArrayCopy());

            return $this->builderContext->getDocument();
        }

        return null;
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
     * Remove empty keys/values from the structure
     *
     * @return void
     */
    protected function sanitizeStructure()
    {
        if ($this->treeStructure instanceof \ArrayObject) {
            $this->treeStructure->exchangeArray(
                \Genesis\Utils\Common::emptyValueRecursiveRemoval(
                    $this->treeStructure->getArrayCopy()
                )
            );
        }
    }

    /**
     * Perform field validation
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     * @return void
     */
    protected function checkRequirements()
    {
        $this->verifyFieldRequirements();

        $this->verifyGroupRequirements();

        $this->verifyConditionalRequirements();

        $this->verifyConditionalFields();
    }

    /**
     * Verify that all required fields are populated
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function verifyFieldRequirements()
    {
        if (isset($this->requiredFields)) {
            $this->requiredFields->setIteratorClass('RecursiveArrayIterator');

            $iterator = new \RecursiveIteratorIterator($this->requiredFields->getIterator());

            foreach ($iterator as $fieldName) {
                if (empty($this->$fieldName)) {
                    throw new \Genesis\Exceptions\ErrorParameter(
                        sprintf('Empty (null) required parameter: %s', $fieldName)
                    );
                }
            }
        }
    }

    /**
     * Verify that the group fields in the request are populated
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function verifyGroupRequirements()
    {
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
                throw new \Genesis\Exceptions\ErrorParameter(
                    sprintf(
                        'One of the following group/s of field/s must be filled in: %s%s',
                        PHP_EOL,
                        implode(
                            PHP_EOL,
                            $groupsFormatted
                        )
                    ),
                    true
                );
            }
        }
    }

    /**
     * Verify that all fields (who depend on previously populated fields) are populated
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function verifyConditionalRequirements()
    {
        if (isset($this->requiredFieldsConditional)) {
            $fields = $this->requiredFieldsConditional->getArrayCopy();

            foreach ($fields as $fieldName => $fieldDependencies) {
                if (isset($this->$fieldName) && !empty($this->$fieldName)) {
                    foreach ($fieldDependencies as $field) {
                        if (empty($this->$field)) {
                            throw new \Genesis\Exceptions\ErrorParameter(
                                sprintf(
                                    '%s is depending on: %s, which is empty (null)!',
                                    $fieldName,
                                    $field
                                )
                            );
                        }
                    }
                }
            }
        }
    }

    /**
     * Verify conditional requirement, where either one of the fields are populated
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function verifyConditionalFields()
    {
        if (isset($this->requiredFieldsOR)) {
            $fields = $this->requiredFieldsOR->getArrayCopy();

            $status = false;

            foreach ($fields as $fieldName) {
                if (isset($this->$fieldName) && !empty($this->$fieldName)) {
                    $status = true;
                }
            }

            if (!$status) {
                throw new \Genesis\Exceptions\ErrorParameter(implode($fields));
            }
        }
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
     * Apply transformation: Convert to Minor currency unit
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
     * @param $sub      String   - gateway/wpf etc.
     * @param $path     String   - path of the current request
     * @param $token    String   - should we append the token to the end of the url
     *
     * @return string            - complete URL
     */
    protected function buildRequestURL($sub = 'gateway', $path = '', $token = '')
    {
        $protocol = ($this->getApiConfig('protocol')) ? $this->getApiConfig('protocol') : 'https';

        $sub      = \Genesis\Config::getSubDomain($sub);

        $domain   = \Genesis\Config::getEndpoint();

        $port     = ($this->getApiConfig('port')) ? $this->getApiConfig('port') : 443;

        $path     = ($token) ? sprintf('%s/%s/', $path, $token) : $path;

        return sprintf(
            '%s://%s%s:%s/%s', $protocol, $sub, $domain, $port, $path
        );
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
     * Create the Tree structure and populate
     * the fields with the set parameters.
     */
    protected function populateStructure()
    {

    }
}
