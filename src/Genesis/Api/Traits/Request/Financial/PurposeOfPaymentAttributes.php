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

use Genesis\Api\Constants\Transaction\Parameters\PurposeOfPayment;
use Genesis\Api\Constants\Transaction\Parameters\PurposeOfPaymentValues;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait PurposeOfPaymentAttributes
 *
 * @package Genesis\Api\Traits\Request\Financial
 *
 * @method string|null getPurposeOfPayment()
 */
trait PurposeOfPaymentAttributes
{
    /**
     * Purpose of Payment: a Visa code (e.g. ISBONU) or its human-readable value
     * (e.g. bonus_payment); Payout also accepts the Mastercard Money Transfer values.
     *
     * @var $purpose_of_payment
     */
    protected $purpose_of_payment;

    /**
     * Set the Purpose of Payment of the transaction.
     *
     * Used for Visa Account Funding Transactions (AFT) and for Visa OCT /
     * Mastercard Money Transfer payouts (Credit, Payout). Some issuer or
     * recipient countries require it (for example Argentina, Bangladesh, Chile,
     * Colombia, Egypt, India, Mexico and Saudi Arabia; the list is not
     * exhaustive and is enforced by the gateway, not by the SDK). When the
     * parameter is absent, the gateway applies its default (ISSAVG).
     *
     * The value is validated strictly against the request's allow-list.
     * `null` clears the value. `''`, non-strings and unknown values throw
     * InvalidArgument and keep the previous value.
     *
     * @param $value
     *
     * @return $this
     *
     * @throws InvalidArgument
    */
    public function setPurposeOfPayment($value)
    {
        return $this->allowedOptionsStrictSetter(
            'purpose_of_payment',
            $this->getAllowedPurposeOfPaymentValues(),
            $value,
            'Parameter Purpose of Payment not valid!'
        );
    }

    /**
     * Visa codes and Visa human-readable values
     *
     * @return array
     */
    protected function getAllowedPurposeOfPaymentValues()
    {
        return array_merge(
            PurposeOfPayment::getCodes(),
            PurposeOfPaymentValues::getAll()
        );
    }
}
