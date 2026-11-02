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

namespace Genesis\Utils;

use Genesis\Exceptions\InvalidArgument;

/**
 * Class ResponseFieldsRenderer
 *
 * Validates and renders the granular (GraphQL-style) response-field selection for GraphQL
 * requests. Only top-level keys are validated against the allowed list; nested field names are
 * rendered as provided by the caller.
 *
 * @package    Genesis
 * @subpackage Utils
 */
class ResponseFieldsRenderer
{
    /**
     * @var string[]
     */
    private $allowedFields;

    /**
     * @param string[] $allowedFields the request's allowed top-level response fields
     */
    public function __construct(array $allowedFields)
    {
        $this->allowedFields = $allowedFields;
    }

    /**
     * Validate that the top-level keys of the selection are allowed.
     *
     * @param array $value
     * @return void
     * @throws InvalidArgument
     */
    public function validate($value)
    {
        if (!Common::isValidArray($value)) {
            throw $this->invalidException();
        }

        foreach ($this->topLevelFields($value) as $field) {
            if (!in_array($field, $this->allowedFields, true)) {
                throw $this->invalidException();
            }
        }
    }

    /**
     * Render a selection array to a GraphQL selection string. Integer-keyed entries are flat
     * scalar fields; string-keyed entries are nested sub-selections (`field { ... }`).
     *
     * @param array $fields
     * @return string
     * @throws InvalidArgument
     */
    public function render(array $fields)
    {
        $parts = [];

        foreach ($fields as $key => $value) {
            if (is_int($key)) {
                $parts[] = $value;
                continue;
            }

            if (!is_array($value) || empty($value)) {
                throw new InvalidArgument(
                    sprintf('Response field "%s" requires a non-empty sub-selection.', $key)
                );
            }

            $parts[] = $key . ' { ' . $this->render($value) . ' }';
        }

        return implode(' ', $parts);
    }

    /**
     * Extract the top-level field names from a mixed flat/nested selection array.
     *
     * @param array $value
     * @return string[]
     */
    private function topLevelFields(array $value)
    {
        $fields = [];

        foreach ($value as $key => $subSelection) {
            $fields[] = is_int($key) ? $subSelection : $key;
        }

        return $fields;
    }

    /**
     * @return InvalidArgument
     */
    private function invalidException()
    {
        return new InvalidArgument(
            'Invalid value/s given for the response fields array. Allowed values: ' .
            implode(', ', $this->allowedFields)
        );
    }
}
