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
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Constants\NonFinancial\KYC;

use Genesis\Utils\Common;

class VerificationDocumentTypes
{
    /**
     * Verifications Document type Passport
     * @var string
     */
    const PASSPORT        = 'passport';

    /**
     * Verifications Document type ID Card
     * @var string
     */
    const ID_CARD         = 'id_card';

    /**
     * Verifications Document type Driving License
     * @var string
     */
    const DRIVING_LICENSE = 'driving_license';

    /**
     * Verifications Document type Credit or Debit card
     * @var string
     */
    const CC_DEB_CARD     = 'credit_or_debit_card';

    /**
     * Read and return all constants as array
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(self::class);
    }
}
