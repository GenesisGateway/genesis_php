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
 * @copyright   Copyright (C) 2015-2025 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Request\Base\Financial\Alternative;

use Genesis\Api\Request\Base\Financial;
use Genesis\Api\Request\Financial\Alternatives\Transaction\Item;
use Genesis\Api\Request\Financial\Alternatives\Transaction\Items;
use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\Financial\Alternatives\Invoice\InvoiceItemsTrait;
use Genesis\Api\Traits\Request\Financial\AsyncAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Currency;

/**
 * Class Invoice
 *
 * Base class for all Invoice requests
 *
 * @package Genesis\Api\Request\Base\Financial\Alternative
 * @method void   setPaymentType(string $value) Set the payment provider type (e.g., 'klarna', 'secure_invoice')
 * @method string getPaymentType()              Get the payment provider type
 * @method Items  getItems()                    Get the list of items for the invoice
 */
abstract class Invoice extends Financial
{
    use AddressInfoAttributes;
    use AsyncAttributes;
    use PaymentAttributes;
    use InvoiceItemsTrait;

    /**
     * Payment provider type: klarna / secure_invoice
     *
     * @var string
     */
    protected $payment_type;

    /**
     * Return additional request attributes
     *
     * @return array
     *
     * @throws InvalidArgument|ErrorParameter
     */
    protected function getPaymentTransactionStructure()
    {
        return array_merge(
            [
                'amount'   => Currency::amountToExponent($this->amount, $this->currency),
                'currency' => $this->currency,
            ],
            $this->items instanceof Items ? $this->items->toArray() : []
        );
    }
}
