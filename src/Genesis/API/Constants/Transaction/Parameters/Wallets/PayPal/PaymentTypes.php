<?php
/*
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
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Constants\Transaction\Parameters\Wallets\PayPal;

use Genesis\Utils\Common as CommonUtils;

/**
 * PayPal allowed payment types
 *
 * Class PaymentTYpes
 * @package Genesis\API\Constants\Transaction\Parameters\Wallets\PayPal
 */
class PaymentTypes
{
    /**
     * Creates an order that should be captured later.
     */
    const AUTHORIZE = 'authorize';

    /**
     * Captures the created order immediately after the buyer confirms the payment.
     */
    const SALE      = 'sale';

    /**
     * Creates an Express Checkout PayPal payment. Express Checkout eliminates one of the
     * major causes of checkout abandonment by giving buyers all the transaction details at
     * once, including order details, shipping options, insurance choices, and tax totals.
     */
    const EXPRESS   = 'express';

    /**
     * Get PayPal allowed Payment Types
     *
     * @return array
     */
    public static function getAllowedPaymentTypes()
    {
        return CommonUtils::getClassConstants(__CLASS__);
    }
}
