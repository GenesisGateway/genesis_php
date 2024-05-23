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
 * Class DocumentTypes
 * @package Genesis\Api\Constants\NonFinancial\Kyc
 */
class DocumentTypes
{
    /**
     * SSN
     *
     * @var int
     */
    const SSN = 0;

    /**
     * Passport Registry
     *
     * @var int
     */
    const PASSPORT_REGISTRY = 1;

    /**
     * Personal ID / National ID
     *
     * @var int
     */
    const PERSONAL_ID = 2;

    /**
     * Identity Card
     *
     * @var int
     */
    const IDENTITY_CARD = 3;

    /**
     * Driver License
     *
     * @var int
     */
    const DRIVER_LICENSE = 4;

    /**
     * Travel Document
     *
     * @var int
     */
    const TRAVEL_DOCUMENT = 8;

    /**
     * Residence Permit
     *
     * @var int
     */
    const RESIDENCE_PERMIT = 12;

    /**
     * Identity Certificate
     *
     * @var int
     */
    const IDENTITY_CERTIFICATE = 13;

    /**
     * Registro Federal de Contribuyentes
     *
     * @var int
     */
    const FEDERAL_REGISTER = 16;

    /**
     * Credencial de Elector
     *
     * @var int
     */
    const ELECTRON_CREDENTIALS = 17;

    /**
     * CPF
     *
     * @var int
     */
    const CPF = 18;

    /**
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(self::class);
    }
}
