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

namespace Genesis\Api\Constants\Transaction\Parameters\Refund;

class CreditReasonIndicatorParameters
{
    /**
     * A: Transport cancellation
     */
    const TRANSPORT_CANCELLATION   = 'A';

    /**
     * B: Travel or transport
     */
    const TRAVEL_TRANSPORT         = 'B';

    /**
     * P: Partial refund or ticket
     */
    const PARTIAL_REFUND_OR_TICKET = 'P';

    /**
     * O: Other
     */
    const OTHER                    = 'O';

    /**
     * Returns list with all Credit Reason Indicator Parameters
     *
     * @return array
     */
    public static function getAll()
    {
        return [
            self::TRANSPORT_CANCELLATION,
            self::TRAVEL_TRANSPORT,
            self::PARTIAL_REFUND_OR_TICKET,
            self::OTHER
        ];
    }
}
