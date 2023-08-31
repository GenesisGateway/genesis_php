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
use Genesis\API\Constants\NonFinancial\KYC\VerificationAddressesTypes;
use Genesis\API\Constants\NonFinancial\KYC\VerificationLanguages;
use Genesis\API\Constants\NonFinancial\KYC\VerificationSupportedModes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Country;

/**
 * trait KycVerifications
 *
 * Setters and getters for KYC Verifications. Build structure, ensure correct types are used where needed
 *
 * @package Genesis\API\Traits\Request\NonFinancial
 *
 * @method string getCountry()
 * @method string getVerificationMode()
 * @method string getLanguage()
 * @method string getReferenceId()
 * @method array  getAddressSupportedTypes()
 */
trait KycVerifications
{
    /**
     * Check and set the correct value for Verifications Country
     *
     * @param $country
     * @return $this
     * @throws InvalidArgument
     */
    public function setCountry($country)
    {
        if (empty($country)) {
            $this->country = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'country',
            Country::getList(),
            $country,
            'Invalid value given for Country.'
        );
    }

    /**
     * Set the correct Verifications Modes
     *
     * @param $verificationMode
     * @return $this
     * @throws InvalidArgument
     * @see VerificationSupportedModes
     */
    public function setVerificationMode($verificationMode)
    {
        return $this->allowedOptionsSetter(
            'verification_mode',
            VerificationSupportedModes::getAll(),
            $verificationMode,
            'Invalid verification mode provided.'
        );
    }

    /**
     * Set the correct language for processing
     *
     * @param $language
     * @return $this
     * @throws InvalidArgument
     * @see VerificationLanguages
     */
    public function setLanguage($language)
    {
        return $this->allowedOptionsSetter(
            'language',
            VerificationLanguages::getAll(),
            $language,
            'Invalid language provided.'
        );
    }

    /**
     * Set the correct Verifications Addresses Types
     *
     * @param $addressType
     * @return $this
     * @throws InvalidArgument
     * @see VerificationAddressesTypes
     */
    public function setAddressSupportedTypes($addressType)
    {
        $getAllowed = VerificationAddressesTypes::getAll();

        if (!is_array($addressType) || array_diff($addressType, $getAllowed)) {
            throw new InvalidArgument(
                sprintf(
                    'Expecting address type to be \'%s\' and \'%s\' provided. Allowed values - %s',
                    'array',
                    gettype($addressType),
                    implode(', ', $getAllowed)
                )
            );
        }

        $this->address_supported_types = $addressType;

        return $this;
    }

    /**
     * Set the correct value for Expiry Date
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setExpiryDate($value)
    {
        if (empty($value)) {
            $this->expiry_date = '';

            return $this;
        }

        return $this->parseDate(
            'expiry_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid value given for Expiry Date'
        );
    }

    /**
     * Get Expiry Date in correct format
     *
     * @return string
     */
    public function getExpiryDate()
    {
        return empty($this->expiry_date)
            ? ''
            : $this->expiry_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * Verify Reference ID value
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setReferenceId($value)
    {
        if (empty($value)) {
            $this->reference_id = null;

            return $this;
        }

        return $this->setLimitedString(
            'reference_id',
            $value,
            self::REFERENCE_ID_MIN_LENGTH,
            self::REFERENCE_ID_MAX_LENGTH
        );
    }
}
