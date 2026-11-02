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
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Request\Base;

use Genesis\Builder;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\ResponseFieldsRenderer;

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
     * Renders and validates the response-field selection (built once with the allowed fields).
     *
     * @var ResponseFieldsRenderer
     */
    private $response_fields_renderer;

    /**
     * @param string $requestPath
     * @param string $requestName
     */
    public function __construct($requestPath, $requestName, $allowedVersions = ['v1'])
    {
        $this->request_path = $requestPath;
        $this->request_name = $requestName;
        $this->response_fields_renderer = new ResponseFieldsRenderer($this->getResponseFieldsAllowedValues());

        parent::__construct($this->request_path, Builder::JSON, $allowedVersions);
    }

    /**
     * Add a single value to the response field list.
     *
     * Accepts a flat field name, or a single [name => sub-selection] pair for a nested
     * (GraphQL-style) selection. Only the top-level name is validated against the allowed list.
     *
     * @param mixed $value
     * @return $this
     * @throws InvalidArgument
     */
    public function addResponseField($value)
    {
        $entry = is_array($value) ? $value : [$value];

        $this->response_fields_renderer->validate($entry);

        foreach ($entry as $key => $selection) {
            // String key: a nested selection, stored by key so re-adding overwrites (de-dups).
            // Integer key: a flat scalar field, deduplicated by addFlatResponseField().
            // array_unique() is unsafe here because the list mixes scalars and nested arrays.
            if (!is_int($key)) {
                $this->response_fields[$key] = $selection;
                continue;
            }

            $this->addFlatResponseField($selection);
        }

        return $this;
    }

    /**
     * Append a flat scalar response field if it is not already selected.
     *
     * @param string $field
     * @return void
     */
    private function addFlatResponseField($field)
    {
        if (!in_array($field, $this->response_fields, true)) {
            $this->response_fields[] = $field;
        }
    }

    /**
     * Set the fields in the response.
     *
     * Accepts flat field names and/or nested [name => sub-selection] arrays. Only the top-level
     * keys are validated against the allowed list; nested field names are rendered as provided.
     *
     * @param array $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setResponseFields($value)
    {
        $this->response_fields_renderer->validate($value);

        $this->response_fields = $value;

        return $this;
    }

    /**
     * Return a formatted string with response fields (supports nested sub-selections).
     *
     * @return string
     * @throws InvalidArgument
     */
    public function getResponseFields()
    {
        return $this->response_fields_renderer->render($this->response_fields);
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
     * Format an array of strings into an escaped GraphQL string-list literal: ["a","b"].
     *
     * Escapes each value with escapeGraphQLString(), so a value containing a character
     * the GraphQL string grammar reserves cannot break the surrounding query. This method
     * adds the one pair of double quotes around each escaped value.
     *
     * @param array $values
     * @return string empty string when the list is empty
     */
    protected function formatArrayToGraphQLStringList(array $values)
    {
        if (empty($values)) {
            return '';
        }

        $escaped = array_map([$this, 'escapeGraphQLString'], $values);

        return sprintf('["%s"]', implode('","', $escaped));
    }

    /**
     * Escape a value for safe inclusion inside a GraphQL double-quoted string.
     *
     * Escapes seven characters: the backslash (\\), the double quote (\"), the newline
     * (\n), the carriage return (\r), the horizontal tab (\t), the backspace (\b) and
     * the form feed (\f).
     *
     * The newline and the carriage return are GraphQL LineTerminators and MUST be
     * escaped: a raw LineTerminator is not a valid StringCharacter, so leaving it in
     * place produces a query the gateway cannot parse. The tab, the backspace and the
     * form feed are valid StringCharacters under the current GraphQL specification and
     * are escaped for robustness against parsers implementing the older SourceCharacter
     * grammar, and for parity with the Genesis Ruby SDK.
     *
     * The backslash is replaced first, so the backslashes introduced by the six other
     * sequences are not escaped a second time.
     *
     * @param mixed $value
     * @return string
     */
    protected function escapeGraphQLString($value)
    {
        $search = [
            '\\',   // must stay first
            '"',
            "\n",
            "\r",
            "\t",
            "\x08", // backspace; PHP has no "\b" escape sequence
            "\f"
        ];

        $replace = ['\\\\', '\\"', '\\n', '\\r', '\\t', '\\b', '\\f'];

        return str_replace($search, $replace, (string) $value);
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
