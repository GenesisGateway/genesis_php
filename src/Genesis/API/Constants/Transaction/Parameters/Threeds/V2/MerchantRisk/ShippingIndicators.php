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

namespace Genesis\API\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk;

use Genesis\Utils\Common;

/**
 * Indicator code that most accurately describes the shipping method for the cardholder specific transaction.
 * If one or more items are included in the sale, use the Shipping Indicator code for the physical goods.
 * If all digital goods, use the code that describes the most expensive item.
 *
 * Class ShippingIndicators
 * @package Genesis\API\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk
 */
class ShippingIndicators
{
    /**
     * Sale as Billing
     */
    const SAME_AS_BILLING  = 'same_as_billing';

    /**
     * Stored Address
     */
    const STORED_ADDRESS   = 'stored_address';

    /**
     * Verified Address
     */
    const VERIFIED_ADDRESS = 'verified_address';

    /**
     * Pick Up
     */
    const PICK_UP          = 'pick_up';

    /**
     * Digital Goods
     */
    const DIGITAL_GOODS    = 'digital_goods';

    /**
     * Travel
     */
    const TRAVEL           = 'travel';

    /**
     * Event Tickets
     */
    const EVENT_TICKETS    = 'event_tickets';

    /**
     * Other
     */
    const OTHER            = 'other';

    /**
     * Get all the Shipping Indicators
     *
     * @return array
     */
    public static function getAll()
    {
        return array_values(Common::getClassConstants(self::class));
    }
}
