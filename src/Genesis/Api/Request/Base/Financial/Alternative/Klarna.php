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

namespace Genesis\Api\Request\Base\Financial\Alternative;

use Genesis\Api\Request\Financial\Alternatives\Klarna\Items;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Exceptions\ErrorParameter;

/**
 * Class Klarna
 *
 * Alternative payment method
 *
 * @package Genesis\Api\Request\Financial\Alternatives\Klarna
 *
 * @method $this setCustomerGender($value) Set gender of the customer
 */
abstract class Klarna extends \Genesis\Api\Request\Base\Financial
{
    use PaymentAttributes;

    /**
     * Items list
     *
     * @var Items
     */
    protected $items;

    /**
     * Set items
     *
     * @param Items $items
     *
     * @return $this
     */
    public function setItems(Items $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return array_merge(
            [
                'amount'   => \Genesis\Utils\Currency::amountToExponent($this->amount, $this->currency),
                'currency' => $this->currency,
            ],
            $this->items instanceof Items ? $this->items->toArray() : []
        );
    }

    /**
     * Perform field validation
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     * @return void
     */
    protected function checkRequirements()
    {
        parent::checkRequirements();

        // verify there is at least one item added
        if (empty($this->items) || $this->items->count() === 0) {
            throw new ErrorParameter('Empty (null) required parameter: items');
        }
    }
}
