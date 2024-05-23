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
use Genesis\Api\Constants\NonFinancial\Kyc\VerificationDocumentTypes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common;

/**
 * Trait KycDocumentVerifications
 *
 * Document represents the data used by the document verification service to check
 * the authenticity of identity documents submitted by customers
 *
 * @package Genesis\Api\Traits\Request\NonFinancial\Kyc
 *
 * @method $this  setDocumentFirstName($value)
 * @method $this  setDocumentLastName($value)
 * @method string getDocumentFirstName()
 * @method string getDocumentLastName()
 * @method bool   getDocumentAllowOffline()
 * @method bool   getDocumentAllowOnline()
 */
trait KycDocumentVerifications
{
    /**
     * Customer's first name
     *
     * @var string
     */
    protected $document_first_name;

    /**
     * Customer's last name
     *
     * @var string
     */
    protected $document_last_name;

    /**
     * Customer's date of birth. just, without at yyyy-mm-dd format, for example - 1990-12-31
     *
     * @var DateTime
     */
    protected $document_date_of_birth;

    /**
     * Whether uploading of previously taken picture is allowed for verification of document/face
     *
     * @var bool
     */
    protected $document_allow_offline;

    /**
     * Whether the realtime usage of device camera is allowed for verification of document/face
     *
     * @var bool
     */
    protected $document_allow_online;

    /**
     * Supported types of document that can be verified
     *
     * @var string
     * @see VerificationDocumentTypes
     */
    protected $document_supported_types;

    /**
     * Set the correct value for Verifications Document Date Of Birth
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setDocumentDateOfBirth($value)
    {
        if (empty($value)) {
            $this->document_date_of_birth = null;

            return $this;
        }

        return $this->parseDate(
            'document_date_of_birth',
            DateTimeFormat::getAll(),
            $value,
            'Invalid value given for Document Date of Birth.'
        );
    }

    /**
     * Get Document Date Of Birth in correct format
     *
     * @return string|null
     */
    public function getDocumentDateOfBirth()
    {
        return empty($this->document_date_of_birth)
            ? null
            : $this->document_date_of_birth->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * Set the correct value for Verifications Document Allow Online
     *
     * @param $value
     * @return $this
     */
    public function setDocumentAllowOnline($value)
    {
        $this->document_allow_online = Common::toBoolean($value);

        return $this;
    }

    /**
     * Set the correct value for Verifications Document Allow Offline
     *
     * @param $value
     * @return $this
     */
    public function setDocumentAllowOffline($value)
    {
        $this->document_allow_offline = Common::toBoolean($value);

        return $this;
    }

    /**
     * Check and set correct Verification Document Type
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
     * Build Verification Document structure
     *
     * @return array
     */
    protected function getVerificationDocumentStructure()
    {
        return [
            'first_name'                => $this->document_first_name,
            'last_name'                 => $this->document_last_name,
            'date_of_birth'             => $this->getDocumentDateOfBirth(),
            'allow_offline'             => $this->document_allow_offline,
            'allow_online'              => $this->document_allow_online
        ];
    }
}
