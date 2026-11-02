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

namespace Genesis\Api\Traits\Request\Financial;

/**
 * Trait OrderAttributes
 *
 * Merchant order data. Groups multiple transactions under a single business order.
 * Requires the merchant-level supports_transaction_order_ids flag to be enabled.
 *
 * @package Genesis\Api\Traits\Request\Financial
 *
 * @method string getOrderId() Merchant order identifier
 */
trait OrderAttributes
{
    /**
     * Maximum allowed length of the order_id value
     *
     * @var int $order_id_max_length
     */
    protected $order_id_max_length = 255;

    /**
     * Merchant order identifier. Groups multiple transactions under a single business order.
     *
     * @var string|null $order_id
     */
    protected $order_id;

    /**
     * Set the merchant order identifier
     *
     * @param string|null $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setOrderId($value)
    {
        if ($value === null) {
            $this->order_id = null;

            return $this;
        }

        return $this->setLimitedString('order_id', $value, null, $this->order_id_max_length);
    }

    /**
     * Return the order attributes request structure
     *
     * @return array
     */
    protected function getOrderAttributesStructure()
    {
        return [
            'order_id' => $this->order_id
        ];
    }
}
