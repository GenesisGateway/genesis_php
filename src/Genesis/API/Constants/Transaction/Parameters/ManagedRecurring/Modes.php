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

/**
 * class Modes
 *
 * Managed Recurring available Modes
 *
 * @package Genesis\API\Constants\Transaction\Parameters\ManagedRecurring
 */
class Modes
{
    /**
     * Managed Recurring Mode Automatic. Mandatory use with Recurring Type Managed.
     * This indicates that the gateway will automatically manage the subsequent recurring transactions.
     */
    const AUTOMATIC = 'automatic';

    /**
     * Manager Recurring Mode Manual. Mandatory use with Indian Cards.
     * This indicates that the merchant will manually manage the subsequent recurring transactions.
     */
    const MANUAL    = 'manual';

    /**
     * Get all available Modes
     *
     * @return array
     */
    public static function getAll()
    {
        return array(
            self::MANUAL,
            self::AUTOMATIC
        );
    }
}
