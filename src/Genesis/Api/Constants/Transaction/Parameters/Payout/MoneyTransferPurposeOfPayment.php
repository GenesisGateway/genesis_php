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
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author      emerchantpay
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Constants\Transaction\Parameters\Payout;

use Genesis\Api\Constants\Transaction\Parameters\PurposeOfPaymentValues;
use Genesis\Utils\Common as CommonUtils;

/**
 * Mastercard Money Transfer Payout Purpose of Payment values.
 *
 * @package Genesis\Api\Constants\Transaction\Parameters\Payout
 */
class MoneyTransferPurposeOfPayment
{
    /** For Family Support */
    const FAMILY_SUPPORT = 'family_support';

    /** For Regular Labour Transfers */
    const REGULAR_LABOR_TRANSFERS = 'regular_labor_transfers';

    /** For Travel and Tourism */
    const TRAVEL_AND_TOURISM = 'travel_and_tourism';

    /** For Hospitalization and Medical Treatment */
    const HOSPITALIZATION_AND_MEDICAL_TREATMENT = 'hospitalization_and_medical_treatment';

    /** For an Emergency */
    const EMERGENCY_NEED = 'emergency_need';

    /** For Savings */
    const SAVINGS = 'savings';

    /** For Gifts */
    const GIFTS = 'gifts';

    /** For Salary */
    const SALARY = 'salary';

    /** For Crowd Lending */
    const CROWD_LENDING = 'crowd_lending';

    /** For Crypto Currency */
    const CRYPTO_CURRENCY = 'crypto_currency';

    /** Refund to Original Card */
    const REFUND_TO_ORIGINAL_CARD = 'refund_to_original_card';

    /** Refund to New Card */
    const REFUND_TO_NEW_CARD = 'refund_to_new_card';

    /** Transfer to another person or organization in the same Staged Digital Wallet (Brazil) */
    const SAME_DIGITAL_WALLET_TRANSFER_TO_PERSON_ORG =
        'same_digital_wallet_transfer_to_person_org';

    /** Boleto Payment (Brazil) */
    const BOLETO_PAYMENT = 'boleto_payment';

    /** High Risk Securities */
    const HIGH_RISK_SECURITIES = 'high_risk_securities';

    /** Recycling Deposit Return */
    const RECYCLING_DEPOSIT = 'recycling_deposit';

    /** VAT Payment */
    const VAT_PAYMENT = 'vat_payment';

    /** For Education (shared with the Visa values) */
    const EDUCATION = PurposeOfPaymentValues::EDUCATION;

    /** Other (shared with the Visa values) */
    const OTHER = PurposeOfPaymentValues::OTHER;

    /**
     * Get all Mastercard Money Transfer Payout Purpose of Payment values.
     *
     * @return array Indexed list of the 19 values
     */
    public static function getAll()
    {
        return array_values(CommonUtils::getClassConstants(self::class));
    }
}
