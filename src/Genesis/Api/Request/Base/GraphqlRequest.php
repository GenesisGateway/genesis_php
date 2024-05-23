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
 * @copyright   Copyright (C) 2015-2024 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Request\Base;

use Genesis\Builder;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class GraphqlRequest
 *
 * @package Genesis\Api\Request\Base
 */
abstract class GraphqlRequest extends BaseVersionedRequest
{
    /**
     * List of fields in the response
     *
     * @var array
     */
    protected $response_fields = [];

    /**
     * @var string
     */
    private $request_path;

    /**
     * The name of the service
     *
     * @var string
     */
    private $request_name;

    /**
     * @param string $requestPath
     * @param string $requestName
     */
    public function __construct($requestPath, $requestName, $allowedVersions = ['v1'])
    {
        $this->request_path = $requestPath;
        $this->request_name = $requestName;

        parent::__construct($this->request_path, Builder::JSON, $allowedVersions);
    }

    /**
     * Add single value to response field list
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function addResponseField($value)
    {
        if (!in_array($value, $this->getResponseFieldsAllowedValues())) {
            throw new InvalidArgument(
                'Invalid value given for response fields. Allowed values: ' .
                implode(', ', $this->getResponseFieldsAllowedValues())
            );
        }

        array_push($this->response_fields, $value);

        $this->response_fields = array_unique($this->response_fields);

        return $this;
    }

    /**
     * Set the fields in the response
     *
     * @param array $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setResponseFields($value)
    {
        if (
            CommonUtils::isValidArray($value)
            && empty(array_diff($value, $this->getResponseFieldsAllowedValues()))
        ) {
            $this->response_fields = $value;
            $this->response_fields = array_unique($this->response_fields);

            return $this;
        }

        throw new InvalidArgument(
            'Invalid value/s given for the response fields array. Allowed values: ' .
            implode(', ', $this->getResponseFieldsAllowedValues())
        );
    }

    /**
     * Return a formatted string with response fields
     *
     * @return string
     */
    public function getResponseFields()
    {
        return sprintf('%s', implode(' ', $this->response_fields));
    }

    /**
     * Initialize the appropriate token for the request
     *
     * @return string
     */
    abstract protected function initGraphqlToken();

    /**
     * Filters that are used in the request
     *
     * @return string
     */
    abstract protected function getRequestFilters();

    /**
     * List of allowed response fields
     *
     * @return string[]
     */
    abstract protected function getResponseFieldsAllowedValues();

    /**
     * Set the per-request configuration
     *
     * @return void
     * @throws EnvironmentNotSet
     */
    protected function initConfiguration()
    {
        $this->initGraphqlConfiguration();

        $this->initGraphqlToken();

        $this->initializeServiceApiRouter($this->request_path);
    }

    /**
     * Initialize GraphQL endpoint
     *
     * @param $request_path
     * @return void
     * @throws \Genesis\Exceptions\EnvironmentNotSet
     */
    protected function initializeServiceApiRouter($request_path)
    {
        $this->initApiGatewayConfiguration(
            $request_path . '/' . $this->getVersion() . '/graphql',
            false,
            'api_service'
        );
    }

    /**
     * Additional query data
     *
     * @return string
     */
    protected function getAdditionalData()
    {
        return '';
    }

    /**
     * Create the request's structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = [
            'query' => sprintf(
                'query {
                    %s(
                        %s
                    ) { 
                        items { %s }
                        %s
                    }   
                }',
                $this->request_name,
                $this->getRequestFilters(),
                $this->getRequestStructure(),
                $this->getAdditionalData()
            )
        ];

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }

    /**
     * Helper to form parts of GraphQL query
     *
     * @param array $elements - GraphQL group of elements in the format
     *      ['name1' => 'value1',
     *       'name2' => 'value2']
     * @param string $element_name - the name of the group of elements in GraphQL
     *      element_name: { name1: value1, name2: value2 }
     * @param string $glue - a separator, example: ', ' in name1: value1, name2: value2
     * @param string $format - the used format, example: '%s: %s' for name1: value1
     * @return string
     */
    protected function generateGraphQLCode($elements, $element_name, $glue = ', ', $format = '%s: %s')
    {
        $elements = array_filter($elements);

        if (empty($elements)) {
            return '';
        }

        return sprintf(
            $element_name . ': { %s }',
            implode(
                $glue,
                array_map(
                    function ($key, $value) use ($format) {
                        return sprintf($format, $key, $value);
                    },
                    array_keys($elements),
                    $elements
                )
            )
        );
    }
}
