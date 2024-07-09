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

namespace Genesis\Api\Request\Financial\Alternatives\Klarna;

use Genesis\Utils\Currency as CurrencyUtils;

/**
 * Class Items
 *
 * Alternative payment method
 *
 * @package Genesis\Api\Request\Financial\Alternatives\Klarna
 *
 */
class Items
{
    /**
     * Currency code in ISO-4217
     *
     * @var string
     */
    protected $currency;

    /**
     * Items list
     *
     * @var Item array
     */
    protected $items = [];

    /**
     * Items constructor.
     * @param $currency
     */
    public function __construct($currency = '')
    {
        if (!empty($currency)) {
            $this->currency = $currency;
        }
    }

    /**
     * Add item
     *
     * @param Item $item
     * @return $this
     */
    public function addItem(Item $item)
    {
        if (!empty($this->currency)) {
            // set currency, so amounts transformations can be done
            $item->setCurrency($this->currency);
        }

        array_push($this->items, $item);
        return $this;
    }

    /**
     * Calculate amount from given items property
     *
     * @return float|int
     */
    public function getAmount()
    {
        return array_reduce($this->items, function ($amount, $item) {
            return $amount + $item->getTotalAmount();
        }, 0);
    }

    /**
     * Calculate amount from given items property
     *
     * @return float|int
     */
    public function getOrderTaxAmount()
    {
        return array_reduce($this->items, function ($amount, $item) {
            return $amount + $item->getTotalTaxAmount();
        }, 0);
    }

    /**
     * Count items
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Return items request attributes
     * @return array
     */
    public function toArray()
    {
        return [
            'order_tax_amount' => (!empty($this->currency)) ?
                CurrencyUtils::amountToExponent($this->getOrderTaxAmount(), $this->currency) :
                $this->getOrderTaxAmount(),
            'items'            => array_map(
                function ($item) {
                    return ['item' => $item->toArray()];
                },
                $this->items
            )
        ];
    }
}
