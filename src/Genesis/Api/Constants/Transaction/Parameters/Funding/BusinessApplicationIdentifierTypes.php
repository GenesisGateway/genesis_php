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

namespace Genesis\Api\Constants\Transaction\Parameters\Funding;

use Genesis\Utils\Common as CommonUtils;

/**
 * Class BusinessApplicationIdentifierTypes
 *
 * @package Genesis\Api\Constants\Transaction\Parameters\Funding
 */
class BusinessApplicationIdentifierTypes
{
    # Type FUNDS_DISBURSEMENT
    const FUNDS_DISBURSEMENT = 'funds_disbursement';

    # Type PENSION_DISBURSEMENT
    const PENSION_DISBURSEMENT = 'pension_disbursement';

    # Type ACCOUNT_TO_ACCOUNT
    const ACCOUNT_TO_ACCOUNT = 'account_to_account';

    # Type BANK_INITIATED
    const BANK_INITIATED = 'bank_initiated';

    # Type FUND_TRANSFER
    const FUND_TRANSFER = 'fund_transfer';

    # Type PERSON_TO_PERSON
    const PERSON_TO_PERSON = 'person_to_person';

    # Type PREPAID_CARD_LOAD
    const PREPAID_CARD_LOAD = 'prepaid_card_load';

    # Type WALLET_TRANSFER
    const WALLET_TRANSFER = 'wallet_transfer';

    # Type LIQUID_ASSETS
    const LIQUID_ASSETS = 'liquid_assets';

    /**
     * Get all Business Application Identifier types
     *
     * @return array
     */
    public static function getAll()
    {
        return CommonUtils::getClassConstants(self::class);
    }
}
