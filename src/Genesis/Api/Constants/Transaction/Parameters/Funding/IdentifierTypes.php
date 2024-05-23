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
 * Class IdentifierTypes
 *
 * Funding identifier types
 *
 * @package Genesis\Api\Constants\Transaction\Parameters\Funding
 */
class IdentifierTypes
{
    /**
     * General person to person
     */
    const GENERAL_PERSON_TO_PERSON = 'general_person_to_person';

    /**
     * Person to person card account
     */
    const PERSON_TO_PERSON_CARD_ACCOUNT = 'person_to_person_card_account';

    /**
     * Own account
     */
    const OWN_ACCOUNT = 'own_account';

    /**
     * Own credit card bill
     */
    const OWN_CREDIT_CARD_BILL = 'own_credit_card_bill';

    /**
     * Business disbursement
     */
    const BUSINESS_DISBURSEMENT = 'business_disbursement';

    /**
     * Government or non profit disbursement
     */
    const GOVERNMENT_OR_NON_PROFIT_DISBURSEMENT = 'government_or_non_profit_disbursement';

    /**
     * Rapid merchant settlement
     */
    const RAPID_MERCHANT_SETTLEMENT = 'rapid_merchant_settlement';

    /**
     * General business to business
     */
    const GENERAL_BUSINESS_TO_BUSINESS = 'general_business_to_business';

    /**
     * Own staged digital wallet account
     */
    const OWN_STAGED_DIGITAL_WALLET_ACCOUNT = 'own_staged_digital_wallet_account';

    /**
     * Own debit or prepaid card account
     */
    const OWN_DEBIT_OR_PREPAID_CARD_ACCOUNT = 'own_debit_or_prepaid_card_account';

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
