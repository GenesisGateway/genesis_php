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

namespace Genesis\Api\Constants\NonFinancial\Payee;

use Genesis\Utils\Common as CommonUtils;

class PayeeDocumentTypes
{
    /**
     * Proof of Identity (e.g., passport, national ID card)
     * @var string
     */
    const POI                          = 'poi';

    /**
     * Proof of Identity Backside (if applicable)
     * @var string
     */
    const POI_BACKSIDE                 = 'poi_backside';

    /**
     * Identity Card
     * @var string
     */
    const ID_CARD                      = 'id_card';

    /**
     * Identity Card Backside (if applicable)
     * @var string
     */
    const ID_CARD_BACKSIDE             = 'id_card_backside';

    /**
     * Passport
     * @var string
     */
    const PASSPORT                     = 'passport';

    /**
     * Driving License
     * @var string
     */
    const DRIVING_LICENSE              = 'driving_license';

    /**
     * Proof of Address (e.g., utility bill, bank statement)
     * @var string
     */
    const POA                          = 'poa';

    /**
     * Utility Bill
     * @var string
     */
    const UTILITY_BILL                 = 'utility_bill';

    /**
     * Bank Statement
     * @var string
     */
    const BANK_STATEMENT               = 'bank_statement';

    /**
     * Rent Agreement
     * @var string
     */
    const RENT_AGREEMENT               = 'rent_agreement';

    /**
     * Employer Letter
     * @var string
     */
    const EMPLOYER_LETTER              = 'employer_letter';

    /**
     * Insurance Agreement
     * @var string
     */
    const INSURANCE_AGREEMENT          = 'insurance_agreement';

    /**
     * Tax Bill
     * @var string
     */
    const TAX_BILL                     = 'tax_bill';

    /**
     * Envelope with address
     * @var string
     */
    const ENVELOPE                     = 'envelope';

    /**
     * CPR Smart Card Reader Copy
     * @var string
     */
    const CPR_SMART_CARD_READER_COPY  = 'cpr_smart_card_reader_copy';

    /**
     * Property Tax Document
     * @var string
     */
    const PROPERTY_TAX                 = 'property_tax';

    /**
     * Lease Agreement
     * @var string
     */
    const LEASE_AGREEMENT              = 'lease_agreement';

    /**
     * Insurance Card
     * @var string
     */
    const INSURANCE_CARD               = 'insurance_card';

    /**
     * Permanent Residence Permit
     * @var string
     */
    const PERMANENT_RESIDENCE_PERMIT   = 'permanent_residence_permit';

    /**
     * Credit Card Statement
     * @var string
     */
    const CREDIT_CARD_STATEMENT        = 'credit_card_statement';

    /**
     * Insurance Policy Document
     * @var string
     */
    const INSURANCE_POLICY             = 'insurance_policy';

    /**
     * E-commerce Receipt
     * @var string
     */
    const E_COMMERCE_RECEIPT           = 'e_commerce_receipt';

    /**
     * Bank Letter Receipt
     * @var string
     */
    const BANK_LETTER_RECEIPT          = 'bank_letter_receipt';

    /**
     * Birth Certificate
     * @var string
     */
    const BIRTH_CERTIFICATE            = 'birth_certificate';

    /**
     * Salary Slip
     * @var string
     */
    const SALARY_SLIP                  = 'salary_slip';

    /**
     * Read and return all constants as array
     * @return array
     */
    public static function getAll()
    {
        return CommonUtils::getClassConstants(self::class);
    }
}
