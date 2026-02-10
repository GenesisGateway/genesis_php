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

namespace Genesis\Api\Traits\Request\NonFinancial\Kyc;

use DateTime;
use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Trait KycBusiness
 *
 * Parameters required to perform business-related AML screening.
 *
 * @method $this  setBackgroundChecksVerificationsBusinessName(string $value) Set the name of the business.
 * @method string getBackgroundChecksVerificationsBusinessName()              Get the name of the business.
 *
 * @package Genesis\Api\Traits\Request\NonFinancial\Kyc
 * @SuppressWarnings(PHPMD.LongVariable)
 */
trait KycBusiness
{
    /**
     * The name of the business. Required when the business section is submitted.
     *
     * @var string
     */
    protected $background_checks_verifications_business_name;

    /**
     * The date of incorporation of the business.
     *
     * @var DateTime
     *
     */
    protected $background_checks_verifications_business_incorporation_date;

    /**
     * Set Incorporation Date
     *
     * @param string $value
     *
     * @return $this
     *
     * @throws InvalidArgument
     */
    public function setBackgroundChecksVerificationsBusinessIncorporationDate($value)
    {
        if (empty($value)) {
            $this->background_checks_verifications_business_incorporation_date = '';

            return $this;
        }

        return $this->parseDate(
            'background_checks_verifications_business_incorporation_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid value given for Expiry Date'
        );
    }

    /**
     * Get Incorporation Date in YYYY-MM-DD format
     *
     * @return string
     */
    public function getBackgroundChecksVerificationsBusinessIncorporationDate()
    {
        return empty($this->background_checks_verifications_business_incorporation_date)
            ? ''
            // phpcs:ignore Generic.Files.LineLength
            : $this->background_checks_verifications_business_incorporation_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'background_checks_verifications_business_name'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * Get Business Structure
     *
     * @return array
     */
    protected function getKycBusinessStructure()
    {
        return [
            'name'               => $this->background_checks_verifications_business_name,
            'incorporation_date' => $this->getBackgroundChecksVerificationsBusinessIncorporationDate()
        ];
    }
}
