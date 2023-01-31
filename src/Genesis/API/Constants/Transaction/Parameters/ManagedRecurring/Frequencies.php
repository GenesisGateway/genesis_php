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

namespace Genesis\API\Constants\Transaction\Parameters\ManagedRecurring;

use Genesis\Utils\Common;

/**
 * class Frequencies
 *
 * Managed Recurring available Frequencies
 * Used for Indian Cards
 *
 * @package Genesis\API\Constants\Transaction\Parameters\ManagedRecurring
 */
class Frequencies
{
    /**
     * Frequency Daily
     */
    const DAILY            = 'daily';

    /**
     * Frequency Twice Weekly
     */
    const TWICE_WEEKLY     = 'twice_weekly';

    /**
     * Frequency Weekly
     */
    const WEEKLY           = 'weekly';

    /**
     * Frequency Ten Days
     */
    const TEN_DAYS         = 'ten_days';

    /**
     * Frequency Fortnightly
     */
    const FORTNIGHTLY      = 'fortnightly';

    /**
     * Frequency Monthly
     */
    const MONTHLY          = 'monthly';

    /**
     * Frequency Every Two Months
     */
    const EVERY_TWO_MONTHS = 'every_two_months';

    /**
     * Frequency Trimester
     */
    const TRIMESTER        = 'trimester';

    /**
     * Frequency Quarterly
     */
    const QUARTERLY        = 'quarterly';

    /**
     * Frequency Twice Yearly
     */
    const TWICE_YEARLY     = 'twice_yearly';

    /**
     * Frequency Annually
     */
    const ANNUALLY         = 'annually';

    /**
     * Frequency Unscheduled
     */
    const UNSCHEDULED      = 'unscheduled';

    /**
     * Get all available Frequencies
     *
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(self::class);
    }
}
