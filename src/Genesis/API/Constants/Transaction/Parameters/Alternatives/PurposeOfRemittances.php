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

namespace Genesis\API\Constants\Transaction\Parameters\Alternatives;

use Genesis\Utils\Common;

/**
 * Identification type
 *
 * Class PurposeOfRemittances
 * @package Genesis\API\Constants\Transaction\Parameters\Alternatives
 */
class PurposeOfRemittances
{
    /**
     * Type Family Support
     */
    const FAMILY_SUPPORT         = 'FAMILY_SUPPORT';

    /**
     * Type Education
     */
    const EDUCATION              = 'EDUCATION';

    /**
     * Type Gift and Donation
     */
    const GIFT_AND_DONATION      = 'GIFT_AND_DONATION';

    /**
     * Type Medical Treatment
     */
    const MEDICAL_TREATMENT      = 'MEDICAL_TREATMENT';

    /**
     * Type Maintenance expenses
     */
    const MAINTENANCE_EXPENSES   = 'MAINTENANCE_EXPENSES';

    /**
     * Type Travel
     */
    const TRAVEL                 = 'TRAVEL';

    /**
     * Type Small value remittance
     */
    const SMALL_VALUE_REMITTANCE = 'SMALL_VALUE_REMITTANCE';

    /**
     * Type Liberalize remittance
     */
    const LIBERALIZED_REMITTANCE = 'LIBERALIZED_REMITTANCE';

    /**
     * Type Other
     */
    const OTHER                  = 'OTHER';

    /**
     * Get all available Purpose of remittance types
     *
     * @return array
     */
    public static function getAll()
    {
        return array_values(Common::getClassConstants(self::class));
    }
}
