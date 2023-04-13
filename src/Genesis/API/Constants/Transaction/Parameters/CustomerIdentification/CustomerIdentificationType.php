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

namespace Genesis\API\Constants\Transaction\Parameters\CustomerIdentification;

use Genesis\Utils\Common;

/**
 * Specifies the type of the document ID.
 *
 * class CustomerIdentificationType
 * @package Genesis\API\Constants\Transaction\Parameters\CustomerIdentification
 */
class CustomerIdentificationType
{
    /**
     * Document ID type - birthdate certificate
     *
     * @var string
     */
    const BIRTH_DATE                  = 'birth_date';

    /**
     * Document ID type - unspecified
     *
     * @var string
     */
    const UNSPECIFIED                 = 'unspecified';

    /**
     * Document ID type - national
     *
     * @var string
     */
    const NATIONAL                    = 'national';

    /**
     * Document ID type - passport number
     *
     * @var string
     */
    const PASSPORT_NUMBER             = 'passport_number';

    /**
     * Document ID type - driver license
     *
     * @var string
     */
    const DRIVER_LICENSE              = 'driver_license';

    /**
     * Document ID type - tax
     *
     * @var string
     */
    const TAX                         = 'tax';

    /**
     * Document ID type - company registration number
     *
     * @var string
     */
    const COMPANY_REGISTRATION_NUMBER = 'company_registration_number';

    /**
     * Document ID type - proxy
     *
     * @var string
     */
    const PROXY                       = 'proxy';

    /**
     * Document ID type - social security number
     *
     * @var string
     */
    const SOCIAL_SECURITY_NUMBER      = 'social_security_number';

    /**
     * Document ID type - alien registration number
     *
     * @var string
     */
    const ALIEN_REGISTRATION_NUMBER   = 'alien_registration_number';

    /**
     * Document ID type - law enforcement
     *
     * @var string
     */
    const LAW_ENFORCEMENT             = 'law_enforcement';

    /**
     * Document ID type - military
     *
     * @var string
     */
    const MILITARY                    = 'military';

    /**
     * Document ID type - travel
     *
     * @var string
     */
    const TRAVEL                      = 'travel';

    /**
     * Document ID type - email
     *
     * @var string
     */
    const EMAIL                       = 'email';

    /**
     * Document ID type - phone number
     *
     * @var string
     */
    const PHONE_NUMBER                = 'phone_number';

    /**
     * Returns all constants as array
     *
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(self::class);
    }
}
