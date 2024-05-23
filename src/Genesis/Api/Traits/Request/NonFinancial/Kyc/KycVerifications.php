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
 * @copyright   Copyright (C) 2015-2024 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\NonFinancial\Kyc;

use DateTime;
use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Constants\NonFinancial\Kyc\VerificationAddressesTypes;
use Genesis\Api\Constants\NonFinancial\Kyc\VerificationLanguages;
use Genesis\Api\Constants\NonFinancial\Kyc\VerificationSupportedModes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Country;

/**
 * trait KycVerifications
 *
 * Setters and getters for KYC Verifications. Build structure, ensure correct types are used where needed
 *
 * @package Genesis\Api\Traits\Request\NonFinancial\Kyc
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
     * Country code in ISO 3166
     *
     * @var string
     */
    protected $country;

    /**
     * This key specifies the types of proof that can be used for verification
     *
     * @var string
     */
    protected $verification_mode;

    /**
     * Supported Language Code
     *
     * @var string
     * @see VerificationLanguages
     */
    protected $language;

    /**
     * Supported types of address that can be verified
     *
     * @var string
     * @see VerificationAddressesTypes
     */
    protected $address_supported_types;

    /**
     * Document's expiry date at yyyy-mm-dd format, for example - 2025-12-31, can be a blank string.
     * A blank string means that the user will need to enter the expiry date from the UI
     *
     * @var DateTime
     */
    protected $expiry_date;

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
}
