<?php
/**
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
 * @author      emerchantpay
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API;

use Genesis\API\Request\Base\Financial\Cards\CreditCard;
use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Validations\Request\Validations;
use Genesis\Builder;
use Genesis\Exceptions\EnvironmentNotSet;
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
    use MagicAccessors, Validations;

    const PROTOCOL_HTTPS = 'https';
    const PORT_HTTPS     = 443;

    const METHOD_POST    = 'POST';
    const METHOD_GET     = 'GET';
    const METHOD_PUT     = 'PUT';

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
     * @throws \Genesis\Exceptions\ErrorParameter
     * @throws \Genesis\Exceptions\InvalidArgument
     * @throws \Genesis\Exceptions\InvalidClassMethod
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
     * @throws \Genesis\Exceptions\InvalidArgument
     * @throws \Genesis\Exceptions\InvalidClassMethod
     * @throws \Genesis\Exceptions\ErrorParameter
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
                    $this->treeStructure->getArrayCopy(),
                    $this->allowedEmptyNotNullFields()
                )
            );
        }
    }

    /**
     * Perform field validation
     *
     * @throws \Genesis\Exceptions\InvalidArgument
     * @throws \Genesis\Exceptions\ErrorParameter
     * @throws \Genesis\Exceptions\InvalidClassMethod
     */
    protected function checkRequirements()
    {
        $this->validate();
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
        if (is_numeric($amount) && !empty($currency)) {
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
     * @throws EnvironmentNotSet
     */
    protected function buildRequestURL($sub = 'gateway', $path = '', $token = '')
    {
        $protocol = ($this->getApiConfig('protocol')) ? $this->getApiConfig('protocol') : 'https';

        $sub      = \Genesis\Config::getSubDomain($sub);

        $domain   = \Genesis\Config::getEndpoint();

        $port     = ($this->getApiConfig('port')) ? $this->getApiConfig('port') : Request::PORT_HTTPS;

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
                'protocol' => Request::PROTOCOL_HTTPS,
                'port'     => Request::PORT_HTTPS,
                'type'     => Request::METHOD_POST,
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
                'protocol' => Request::PROTOCOL_HTTPS,
                'port'     => Request::PORT_HTTPS,
                'type'     => Request::METHOD_POST,
                'format'   => Builder::JSON
            ]
        );
    }

    /**
     * Configures a Secure Post Request with Form body
     *
     * @return void
     */
    protected function initFormConfiguration()
    {
        $this->config = CommonUtils::createArrayObject(
            [
                'protocol' => Request::PROTOCOL_HTTPS,
                'port'     => Request::PORT_HTTPS,
                'type'     => Request::METHOD_POST,
                'format'   => Builder::FORM
            ]
        );
    }

    /**
     * Initializes Api EndPoint Url with request path & terminal token
     *
     * @param string $requestPath
     * @param bool $includeToken
     * @return void
     * @throws EnvironmentNotSet
     */
    protected function initApiGatewayConfiguration(
        $requestPath = 'process',
        $includeToken = true,
        $subdomain = 'gateway'
    )
    {
        $this->setApiConfig(
            'url',
            $this->buildRequestURL(
                $subdomain,
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

    /**
     * Return the required parameters keys which values could evaluate as empty
     * Example value:
     * array(
     *     'class_property' => 'request_structure_key'
     * )
     *
     * @return array
     */
    protected function allowedEmptyNotNullFields()
    {
        return array();
    }
}
