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

namespace Genesis\Api\Traits\Request\NonFinancial;

use Genesis\Api\Constants\NonFinancial\Scopes;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait Scope
 * @package Genesis\Api\Traits\Request\NonFinancial
 */
trait Scope
{
    /**
     * Filters transactions by the requested scope
     *
     * @var string $scope
     */
    protected $scope;

    /**
     * Filters transactions by the requested scope
     *
     * Non-string values (bool, int, etc.) are rejected explicitly, because the
     * underlying allowedOptionsSetter() uses a non-strict in_array() comparison
     * that would otherwise accept values such as true or 0.
     *
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setScope($value)
    {
        if ($value === null) {
            $this->scope = null;

            return $this;
        }

        if (!is_string($value)) {
            throw new InvalidArgument('Invalid value for scope attribute. A string value is expected.');
        }

        return $this->allowedOptionsSetter(
            'scope',
            Scopes::getAll(),
            $value,
            'Invalid value for scope attribute.'
        );
    }

    /**
     * Get the currently set scope value
     *
     * @return string|null
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Build the scope fragment of the request tree structure
     *
     * @return array
     */
    protected function getScopeStructure()
    {
        return [
            'scope' => $this->scope
        ];
    }
}
