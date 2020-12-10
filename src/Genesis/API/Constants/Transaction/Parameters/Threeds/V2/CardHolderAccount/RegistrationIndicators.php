<?php
/*
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
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount;

use Genesis\Utils\Common;

/**
 * Indicates the length of time that the payment account was enrolled in the cardholder’s account
 * with the 3DS Requester.
 *
 * Class RegistrationIndicators
 * @package Genesis\API\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount
 */
class RegistrationIndicators
{
    /**
     * Guest Checkout
     */
    const GUEST_CHECKOUT = 'guest_checkout';

    /**
     * Current Transaction
     */
    const CURRENT_TRANSACTION = 'current_transaction';

    /**
     * Less than 30 days
     */
    const LESS_THAN_30DAYS    = 'less_than_30days';

    /**
     * From 30 to 60 days
     */
    const FROM_30_TO_60_DAYS  = '30_to_60_days';

    /**
     * More than 60 days
     */
    const MORE_THAN_60DAYS    = 'more_than_60days';

    /**
     * Get all the Registration Indicators
     *
     * @return array
     */
    public static function getAll()
    {
        return array_values(Common::getClassConstants(self::class));
    }
}
