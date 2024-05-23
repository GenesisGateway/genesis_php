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

/**
 * List with the available values for CredentialOnFile (COF) Parameter
 *
 * Class CredentialOnFile
 * @package Genesis\Api\Constants\Transaction\Parameters
 */
class CredentialOnFile
{
    /**
     * Initial transaction used to store payment credentials for future customer initiated payments while processing.
     * Required for external tokenization, and optional for gateway-based tokenization
     */
    const INITIAL_CUSTOMER_INITIATED    = 'initial_customer_initiated';

    /**
     * Subsequent customer initiated transaction using previously stored payment credentials.
     * Required for external tokenization, and optional for gateway-based tokenization
     */
    const SUBSEQUENT_CUSTOMER_INITIATED = 'subsequent_customer_initiated';

    /**
     * For UCOF transaction, the scheme transaction identifier of the initial transaction must be sent in
     * the transaction request. For MasterCard or Maestro UCOF, the scheme settlement date in MMDD format
     * (e.g. 0107) of the initial transaction must be sent in the transaction request.
     */
    const MERCHANT_UNSCHEDULED          = 'merchant_unscheduled';

    /**
     * Retrieve all available parameters for Credential on File attribute
     *
     * @return array
     */
    public static function getAll()
    {
        return [
            self::INITIAL_CUSTOMER_INITIATED,
            self::SUBSEQUENT_CUSTOMER_INITIATED,
            self::MERCHANT_UNSCHEDULED
        ];
    }
}
