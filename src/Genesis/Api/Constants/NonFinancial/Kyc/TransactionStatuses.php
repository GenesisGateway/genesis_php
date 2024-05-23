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
 * Class TransactionStatuses
 * @package Genesis\Api\Constants\NonFinancial\Kyc
 */
class TransactionStatuses
{
    /**
     * Approved
     *
     * @var int
     */
    const APPROVED = 1;

    /**
     * Pre-Auth
     *
     * @var int
     */
    const PRE_AUTH = 2;

    /**
     * Settled
     *
     * @var int
     */
    const SETTLED = 3;

    /**
     * Void
     *
     * @var int
     */
    const VOID = 4;

    /**
     * Rejected internally by Negative Database or other scrubber decided to reject the transaction
     *
     * @var int
     */
    const REJECTED = 5;

    /**
     * Declined the bank / gateway / processor rejected the transaction
     *
     * @var int
     */
    const DECLINED = 6;

    /**
     * Chargeback
     *
     * @var int
     */
    const CHARGEBACK = 7;

    /**
     * Return
     *
     * @var int
     */
    const RETURN     = 8;

    /**
     * Pending
     *
     * @var int
     */
    const PENDING = 9;

    /**
     * Pass Transaction validation
     *
     * @var int
     */
    const PASS = 10;

    /**
     * Failed ransaction validation
     *
     * @var int
     */
    const FAILED = 11;

    /**
     * Refund
     *
     * @var int
     */
    const REFUND = 12;

    /**
     * Approved Review
     *
     * @var int
     */
    const APPROVED_REVIEW = 13;

    /**
     * Abandon - This status is used when the user just leaves the transaction
     *
     * @var int
     */
    const ABANDON = 14;

    /**
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(self::class);
    }
}
