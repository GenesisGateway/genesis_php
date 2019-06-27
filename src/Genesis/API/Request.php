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

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Validators\Request\Base\Validator as RequestValidator;
use Genesis\Builder;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Request
 *
 * Base of every API request
 *
 * @package    Genesis
 * @subpackage API
 *
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
abstract class Request
{
    use MagicAccessors;

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
     * Store the names of the field values that are Required
     *
     * @var \ArrayObject
     */
    protected $requiredFieldValues;

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
     * Interface for request builder
     *
     * @var string
     */
    protected $builderInterface;

    /**
     * Bootstrap per-request configuration
     *
     * @param string $builderInterface Defaults to XML
     */
    public function __construct($builderInterface = Builder::XML)
    {
        $this->builderInterface = $builderInterface;

        $this->initConfiguration();

        // A request might not always feature 'required' fields
        if (method_exists($this, 'setRequiredFields')) {
            $this->setRequiredFields();
        }
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
            $this->builderContext = new \Genesis\Builder($this->builderInterface);
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
                CommonUtils::emptyValueRecursiveRemoval(
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

        $this->verifyFieldValuesRequirements();

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
     * Verify that all required fields are populated with expected values
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    protected function verifyFieldValuesRequirements()
    {
        if (!isset($this->requiredFieldValues)) {
            return;
        }

        $iterator = $this->requiredFieldValues->getArrayCopy();

        foreach ($iterator as $fieldName => $validator) {
            if ($validator instanceof RequestValidator) {
                $validator->run($this, $fieldName);

                continue;
            }

            if (CommonUtils::isValidArray($validator)) {
                if (!in_array($this->$fieldName, $validator)) {
                    throw new \Genesis\Exceptions\ErrorParameter(
                        sprintf(
                            'Required parameter %s is set to %s, but expected to be one of (%s)',
                            $fieldName,
                            $this->$fieldName,
                            implode(
                                ', ',
                                CommonUtils::getSortedArrayByValue($validator)
                            )
                        )
                    );
                }

                continue;
            }

            if ($this->$fieldName !== $validator) {
                throw new \Genesis\Exceptions\ErrorParameter(
                    sprintf(
                        'Required parameter %s is set to %s, but expected to be %s',
                        $fieldName,
                        $this->$fieldName,
                        $validator
                    )
                );
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
            $groupsFormatted = [];

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
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function verifyConditionalRequirements()
    {
        if (!isset($this->requiredFieldsConditional)) {
            return;
        }

        $fields = $this->requiredFieldsConditional->getArrayCopy();

        foreach ($fields as $fieldName => $fieldDependencies) {
            if (!isset($this->$fieldName)) {
                continue;
            }

            foreach ($fieldDependencies as $fieldValue => $fieldDependency) {
                if (is_array($fieldDependency)) {
                    if ($this->$fieldName != $fieldValue) {
                        continue;
                    }

                    foreach ($fieldDependency as $field) {
                        if (empty($this->$field)) {
                            $fieldValue =
                                is_bool($this->$fieldName)
                                    ? var_export($this->$fieldName, true)
                                    : $this->$fieldName;

                            throw new \Genesis\Exceptions\ErrorParameter(
                                sprintf(
                                    '%s with value %s is depending on: %s, which is empty (null)!',
                                    $fieldName,
                                    $fieldValue,
                                    $field
                                )
                            );
                        }
                    }
                } elseif (empty($this->$fieldDependency)) {
                    throw new \Genesis\Exceptions\ErrorParameter(
                        sprintf(
                            '%s is depending on: %s, which is empty (null)!',
                            $fieldName,
                            $fieldDependency
                        )
                    );
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
        $method = $prefix . CommonUtils::snakeCaseToCamelCase($method);

        if (method_exists($this, $method)) {
            $result = call_user_func_array([$this, $method], $args);

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
            '%s://%s%s:%s/%s',
            $protocol,
            $sub,
            $domain,
            $port,
            $path
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
     * Configures a Secured Post Request with Xml body
     *
     * @return void
     */
    protected function initXmlConfiguration()
    {
        $this->config = CommonUtils::createArrayObject(
            [
                'protocol' => 'https',
                'port'     => 443,
                'type'     => 'POST',
                'format'   => Builder::XML
            ]
        );
    }

    /**
     * Configures a Secured Post Request with Json body
     *
     * @return void
     */
    protected function initJsonConfiguration()
    {
        $this->config = CommonUtils::createArrayObject(
            [
                'protocol' => 'https',
                'port'     => 443,
                'type'     => 'POST',
                'format'   => Builder::JSON
            ]
        );
    }

    /**
     * Initializes Api EndPoint Url with request path & terminal token
     *
     * @param string $requestPath
     * @param bool $includeToken
     * @return void
     */
    protected function initApiGatewayConfiguration($requestPath = 'process', $includeToken = true)
    {
        $this->setApiConfig(
            'url',
            $this->buildRequestURL(
                'gateway',
                $requestPath,
                ($includeToken ? \Genesis\Config::getToken() : false)
            )
        );
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
