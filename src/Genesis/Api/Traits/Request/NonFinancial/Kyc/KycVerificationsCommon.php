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
 * @copyright   Copyright (C) 2015-2025 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\NonFinancial\Kyc;

use DateTime;
use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Constants\NonFinancial\Kyc\VerificationDocumentTypes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common;
use Genesis\Utils\Country;

/**
 * Trait KycVerificationsCommon
 *
 * Common parameters for KYC Verifications
 *
 * @package Genesis\Api\Traits\Request\NonFinancial\Kyc
 *
 * @method bool   getBacksideProofRequired();
 * @method string getCountry()
 * @method string getEmail();
 * @method string getVerificationMode()
 * @method string getReferenceId()
 * @method $this  setEmail($value);
 */
trait KycVerificationsCommon
{
    /**
     * User's email
     *
     * @var string
     */
    protected $email;

    /**
     * Country code in ISO 3166
     *
     * @var string
     */
    protected $country;

    /**
     * Document's expiry date
     *
     * @var DateTime
     */
    protected $expiry_date;

    /**
     * Signifies that both sides of the document are required to verify the identity
     *
     * @var bool
     */
    protected $backside_proof_required;

    /**
     * Supported document types that can be verified
     *
     * @var string
     * @see VerificationDocumentTypes
     */
    protected $document_supported_types;

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
     * Get Expiry Date in the correct format
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
        $referenceIdMinLength = 6;
        $referenceIdMaxLength = 250;

        if (empty($value)) {
            $this->reference_id = null;

            return $this;
        }

        return $this->setLimitedString(
            'reference_id',
            $value,
            $referenceIdMinLength,
            $referenceIdMaxLength
        );
    }

    /**
     * Check and set the correct Verification Document Type
     *
     * @param array $documentSupportedTypes Array with Document Types
     * @return $this
     * @throws InvalidArgument
     * @see VerificationDocumentTypes
     */
    public function setDocumentSupportedTypes($documentSupportedTypes)
    {
        $getAllowed = VerificationDocumentTypes::getAll();

        if (!is_array($documentSupportedTypes) || array_diff($documentSupportedTypes, $getAllowed)) {
            throw new InvalidArgument(
                sprintf(
                    'Expecting document type to be \'%s\' and \'%s\' provided. Allowed values - %s',
                    'array',
                    gettype($documentSupportedTypes),
                    implode(', ', $getAllowed)
                )
            );
        }

        $this->document_supported_types = $documentSupportedTypes;

        return $this;
    }

    /**
     * Set the correct value for Backside Proof Required
     *
     * @param $value
     * @return $this
     */
    public function setBacksideProofRequired($value)
    {
        $this->backside_proof_required = Common::toBoolean($value);

        return $this;
    }
}
