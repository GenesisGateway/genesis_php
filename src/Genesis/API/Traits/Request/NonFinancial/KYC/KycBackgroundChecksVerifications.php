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

namespace Genesis\API\Traits\Request\NonFinancial\KYC;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common;

/**
 * Trait KycBackgroundChecksVerifications
 *
 * An AML (anti-money laundering) background check will be done based on the provided data.
 * Please note that the name and the date of birth keys will be extracted from the document service
 * if they are missing.
 *
 * @package Genesis\API\Traits\Request\NonFinancial\KYC
 *
 * @method $this  setBackgroundChecksFirstName($value);
 * @method $this  setBackgroundChecksMiddleName($value);
 * @method $this  setBackgroundChecksLastName($value);
 * @method $this  setBackgroundChecksFullName($value);
 * @method string getBackgroundChecksFirstName()
 * @method string getBackgroundChecksMiddleName()
 * @method string getBackgroundChecksLastName()
 * @method string getBackgroundChecksFullName()
 * @method bool   getBackgroundChecksAsyncUpdate()
 */
trait KycBackgroundChecksVerifications
{
    /**
     * Customer's first name
     *
     * @var string
     */
    protected $background_checks_first_name;

    /**
     * Customer's middle name
     *
     * @var string
     */
    protected $background_checks_middle_name;

    /**
     * Customer's last name
     *
     * @var string
     */
    protected $background_checks_last_name;

    /**
     * Customer's full name
     *
     * @var string
     */
    protected $background_checks_full_name;

    /**
     * Customer's date of birth. just, without at yyyy-mm-dd format, for example - 1990-12-31
     *
     * @var DateTime
     */
    protected $background_checks_date_of_birth;

    /**
     * Will allow the system to send notifications with information about the checked person when the status
     * has been changed. The registered asynchronous update doesn't expire and notification will be sent
     * on each change, but not often than 15 minutes
     *
     * @var bool
     */
    protected $background_checks_async_update;

    /**
     * Set the correct value for Verifications Background Checks Date Of Birth
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setBackgroundChecksDateOfBirth($value)
    {
        if (empty($value)) {
            $this->background_checks_date_of_birth = null;

            return $this;
        }

        return $this->parseDate(
            'background_checks_date_of_birth',
            DateTimeFormat::getAll(),
            $value,
            'Invalid value given for Background Checks Date of Birth.'
        );
    }

    /**
     * Get Background Checks Date Of Birth in correct format
     *
     * @return string|null
     */
    public function getBackgroundChecksDateOfBirth()
    {
        return empty($this->background_checks_date_of_birth)
            ? null
            : $this->background_checks_date_of_birth->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * Set the correct Verifications Async Update - boolean
     *
     * @param $value
     * @return $this
     */
    public function setBackgroundChecksAsyncUpdate($value)
    {
        $this->background_checks_async_update = Common::toBoolean($value);

        return $this;
    }

    /**
     * Get the correct structure for Verifications Background Checks
     *
     * @return array
     */
    protected function getVerificationBackgroundChecksStructure()
    {
        return [
            'first_name'    => $this->background_checks_first_name,
            'middle_name'   => $this->background_checks_middle_name,
            'last_name'     => $this->background_checks_last_name,
            'full_name'     => $this->background_checks_full_name,
            'date_of_birth' => $this->getBackgroundChecksDateOfBirth(),
            'async_update'  => $this->background_checks_async_update,
        ];
    }
}
