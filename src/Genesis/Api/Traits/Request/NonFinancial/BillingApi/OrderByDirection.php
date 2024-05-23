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

namespace Genesis\Api\Traits\Request\NonFinancial\BillingApi;

use Genesis\Exceptions\InvalidArgument;

/**
 * Trait OrderByDirection
 * @package Genesis\Api\Traits\Request\NonFinancial\BillingApi
 *
 * @method string getOrderByDirection()
 */
trait OrderByDirection
{
    /**
     * Direction result collection is sorted by.
     * Possible values: asc, desc. Default value: asc
     *
     * @var string
     */
    protected $order_by_direction;

    /**
     * Set the order by direction parameter
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setOrderByDirection($value)
    {
        return $this->allowedOptionsSetter(
            'order_by_direction',
            $this->getOrderByDirectionAllowedValues(),
            strtolower($value),
            'Invalid value given for orderByDirection. Allowed values: ' .
            implode(', ', $this->getOrderByDirectionAllowedValues())
        );
    }

    /**
     * List of allowed response ordering directions
     *
     * @return string[]
     */
    protected function getOrderByDirectionAllowedValues()
    {
        return ['asc', 'desc'];
    }
}
