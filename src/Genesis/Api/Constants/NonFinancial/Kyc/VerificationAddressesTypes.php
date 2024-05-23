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

namespace Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Utils\Common;

/**
 * class VerificationAddressesTypes
 * @package Genesis\Api\Constants\NonFinancial\Kyc
 */
class VerificationAddressesTypes
{
    /**
     * Verification Address type ID Card
     *
     * @var string
     */
    const ID_CARD               = 'id_card';

    /**
     * Verification Address type Passport
     *
     * @var string
     */
    const PASSPORT              = 'passport';

    /**
     * Verification Address type Driving License
     *
     * @var string
     */
    const DRIVING_LICENSE       = 'driving_license';

    /**
     * Verification Address type Utility bill
     *
     * @var string
     */
    const UTILITY_BILL          = 'utility_bill';

    /**
     * Verification Address type Bank Statement
     *
     * @var string
     */
    const BANK_STATEMENT        = 'bank_statement';

    /**
     * Verification Address type Rent Agreement
     *
     * @var string
     */
    const RENT_AGREEMENT        = 'rent_agreement';

    /**
     * Verification Address type Employer Letter
     *
     * @var string
     */
    const EMPLOYER_LETTER       = 'employer_letter';

    /**
     * Verification Address type Insurance Agreement
     *
     * @var string
     */
    const INSURANCE_AGREEMENT   = 'insurance_agreement';

    /**
     * Verification Address type Tax Bill
     *
     * @var string
     */
    const TAX_BILL              = 'tax_bill';

    /**
     * Verification Address type Envelope
     *
     * @var string
     */
    const ENVELOPE              = 'envelope';

    /**
     * Verification Address type CPR/Smart Card Reader
     *
     * @var string
     */
    const CPR_SMART_CARD_READER = 'cpr_smart_card_reader_copy';

    /**
     * Read and return all constants as array
     *
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(self::class);
    }
}
