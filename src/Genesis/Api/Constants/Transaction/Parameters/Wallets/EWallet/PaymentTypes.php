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

namespace Genesis\Api\Constants\Transaction\Parameters\Wallets\EWallet;

use Genesis\Utils\Common as CommonUtils;

/**
 * eWallet allowed payment types
 *
 * The values are the exact provider names expected by the gateway. No normalisation
 * is applied, because the request and WPF validations compare them with a strict in_array.
 *
 * Class PaymentTypes
 * @package Genesis\Api\Constants\Transaction\Parameters\Wallets\EWallet
 */
class PaymentTypes
{
    /**
     * Airtel Money e-wallet provider
     */
    const AIRTEL_MONEY = 'Airtel Money';

    /**
     * Amazon pay e-wallet provider
     */
    const AMAZON_PAY   = 'Amazon pay';

    /**
     * Free Charge e-wallet provider
     */
    const FREE_CHARGE  = 'Free Charge';

    /**
     * Jio Money e-wallet provider
     */
    const JIO_MONEY    = 'Jio Money';

    /**
     * Ola Money e-wallet provider
     */
    const OLA_MONEY    = 'Ola Money';

    /**
     * Paytm e-wallet provider
     */
    const PAYTM        = 'Paytm';

    /**
     * Payzapp e-wallet provider
     */
    const PAYZAPP      = 'Payzapp';

    /**
     * PhonePe e-wallet provider
     */
    const PHONE_PE     = 'PhonePe';

    /**
     * Get eWallet allowed Payment Types
     *
     * @return array
     */
    public static function getAllowedPaymentTypes()
    {
        return CommonUtils::getClassConstants(__CLASS__);
    }
}
