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

namespace Genesis\Api\Constants\Transaction\Parameters;

use Genesis\Utils\Common;

/**
 * Class ScaExemptions
 * @package Genesis\Api\Constants\Transaction\Parameters
 */
class ScaExemptions
{
    /**
     * Exemption Low Value
     */
    const EXEMPTION_LOW_VALUE = 'low_value';

    /**
     * Exemption Low Risk
     */
    const EXEMPTION_LOW_RISK = 'low_risk';

    /**
     * Exemption Trusted Merchant
     */
    const EXEMPTION_TRUSTED_MERCHANT = 'trusted_merchant';

    /**
     * Exemption Corporate Payment
     */
    const EXEMPTION_CORPORATE_PAYMENT = 'corporate_payment';

    /**
     * Exemption Delegated Authentication
     */
    const EXEMPTION_DELEGATED_AUTHENTICATION = 'delegated_authentication';

    /**
     * Exemption Auth Network Outage
     */
    const EXEMPTION_AUTH_NETWORK_OUTAGE = 'auth_network_outage';

    /**
     * Get all the available Exemption values
     *
     * @return array
     */
    public static function getAll()
    {
        return array_values(Common::getClassConstants(self::class));
    }
}
