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

namespace Genesis\API\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk;

/**
 * Indicates whether cardholder is placing an order for merchandise with a future-availability or release date.
 *
 * Class PreOrderPurchaseIndicators
 * @package Genesis\API\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk
 */
class PreOrderPurchaseIndicators
{
    /**
     * Merchandise Available
     */
    const MERCHANDISE_AVAILABLE = 'merchandise_available';

    /**
     * Future Availability
     */
    const FUTURE_AVAILABILITY   = 'future_availability';

    /**
     * Get all the Pre Order Purchase Indicators
     *
     * @return array
     */
    public static function getAll()
    {
        return [
            self::MERCHANDISE_AVAILABLE, self::FUTURE_AVAILABILITY
        ];
    }
}
