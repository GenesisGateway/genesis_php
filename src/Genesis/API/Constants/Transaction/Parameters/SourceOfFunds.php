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

namespace Genesis\API\Constants\Transaction\Parameters;

use Genesis\Utils\Common;

/**
 * Class SourceOfFunds
 * @package Genesis\API\Constants\Transaction\Parameters
 */
class SourceOfFunds
{
    /**
     * Source of Funds Credit
     */
    const CREDIT = 'credit';

    /**
     * Source of Funds Debit
     */
    const DEBIT = 'debit';

    /**
     * Source of Funds Prepaid
     */
    const PREPAID = 'prepaid';

    /**
     * Source of Funds Cash
     */
    const CASH = 'cash';

    /**
     * Source of Funds OTHER DEBIT ACCOUNT
     */
    const OTHER_DEBIT_ACCOUNT = 'other_debit_account';

    /**
     * Source of funds OTHER CREDIT ACCOUNT
     */
    const OTHER_CREDIT_ACCOUNT = 'other_credit_account';

    /**
     * Get all Source of Funds values in array
     *
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(__CLASS__);
    }
}
