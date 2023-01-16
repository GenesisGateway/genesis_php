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
 * Identification type
 *
 * Class IdentificationTypes
 * @package Genesis\API\Constants\Transaction\Parameters
 */
class IdentificationTypes
{
    /**
     * Passport
     */
    const PASSPORT           = 'PASSPORT';

    /**
     * National ID
     */
    const NATIONAL_ID        = 'NATIONAL_ID';

    /**
     * Driving License
     */
    const DRIVING_LICENSE    = 'DRIVING_LICENSE';

    /**
     * Social Security
     */
    const SOCIAL_SECURITY    = 'SOCIAL_SECURITY';

    /**
     * Tax ID
     */
    const TAX_ID             = 'TAX_ID';

    /**
     * Senior Citizen ID
     */
    const SENIOR_CITIZEN_ID  = 'SENIOR_CITIZEN_ID';

    /**
     * Birth Certificate
     */
    const BIRTH_CERTIFICATE  = 'BIRTH_CERTIFICATE';

    /**
     * Village Elder ID
     */
    const VILLAGE_ELDER_ID   = 'VILLAGE_ELDER_ID';

    /**
     * Resident Card
     */
    const RESIDENT_CARD      = 'RESIDENT_CARD';

    /**
     * Alien Registration
     */
    const ALIEN_REGISTRATION = 'ALIEN_REGISTRATION';

    /**
     * Pan Card
     */
    const PAN_CARD           = 'PAN_CARD';

    /**
     * Voters ID
     */
    const VOTERS_ID          = 'VOTERS_ID';

    /**
     * Health Card
     */
    const HEALTH_CARD        = 'HEALTH_CARD';

    /**
     * Employer ID
     */
    const EMPLOYER_ID        = 'EMPLOYER_ID';

    /**
     * Other
     */
    const OTHER              = 'OTHER';

    /**
     * Get All Identification Types
     *
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(self::class);
    }
}
