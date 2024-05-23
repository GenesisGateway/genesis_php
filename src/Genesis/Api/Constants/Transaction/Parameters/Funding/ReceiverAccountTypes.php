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

namespace Genesis\Api\Constants\Transaction\Parameters\Funding;

use Genesis\Utils\Common as CommonUtils;

/**
 * Class ReceiverAccountTypes
 *
 * Funding Receiver Account types
 *
 * @package Genesis\Api\Constants\Transaction\Parameters\Funding
 */
class ReceiverAccountTypes
{
    /**
     * Routing Transit Number and Bank Account Number
     */
    const RTN_AND_BANK_ACCOUNT_NUMBER = 'rtn_and_bank_account_number';

    /**
     * International Bank Account Number
     */
    const IBAN = 'iban';

    /**
     * Card Account
     */
    const CARD_ACCOUNT = 'card_account';

    /**
     * Electronic Mail
     */
    const EMAIL = 'email';

    /**
     * Phone Number
     */
    const PHONE_NUMBER = 'phone_number';

    /**
     * Bank Account Number and Business Identifier Code
     */
    const BANK_ACCOUNT_NUMBER_AND_BIC = 'bank_account_number_and_bic';

    /**
     * Wallet ID
     */
    const WALLET_ID = 'wallet_id';

    /**
     * Unique Identifier for Social Network Application
     */
    const SOCIAL_NETWORK_ID = 'social_network_id';

    /**
     * Any other type
     */
    const OTHER = 'other';

    /**
     * Get all identifier types
     *
     * @return array
     */
    public static function getAll()
    {
        return CommonUtils::getClassConstants(self::class);
    }
}
