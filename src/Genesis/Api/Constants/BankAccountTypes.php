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

namespace Genesis\Api\Constants;

/**
 * Class BankAccountTypes
 * @package Genesis\Api\Constants
 */
class BankAccountTypes
{
    /**
     * C: for Checking accounts
     */
    const CHECKING_ACCOUNT = 'C';

    /**
     * S: for Savings accounts
     */
    const SAVINGS_ACCOUNT  = 'S';

    /**
     * M: for Maestra accounts(Only Peru)
     */
    const MAESTRA_ACCOUNTS = 'M';

    /**
     * P: for Payment accounts
     */
    const PAYMENT_ACCOUNT = 'P';

    public static function getAll()
    {
        return [
            self::CHECKING_ACCOUNT,
            self::SAVINGS_ACCOUNT,
            self::MAESTRA_ACCOUNTS,
            self::PAYMENT_ACCOUNT
        ];
    }
}
