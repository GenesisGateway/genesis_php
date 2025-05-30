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
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait KycIdentityVerifications
 *
 * Document represents the data used by the document verification service to check the authenticity
 * of identity documents submitted by customers
 *
 * @package Genesis\Api\Traits\Request\NonFinancial\Kyc
 *
 * @method string getDocumentFirstName()
 * @method string getDocumentMiddleName()
 * @method string getDocumentLastName()
 * @method bool   getDocumentFullAddress()
 * @method string getDocumentProof()
 * @method $this  setDocumentProof($value)
 */
trait KycIdentityVerifications
{
    /**
     * Base64 encoded image of the document
     *
     * @var string
     */
    protected $document_proof;

    /**
     * Customer's date of birth, yyyy-mm-dd format, for example - 1990-12-31
     *
     * @var DateTime
     */
    protected $document_date_of_birth;

    /**
     * Customer's first name
     *
     * @var string
     */
    protected $document_first_name;

    /**
     * Customer's middle name
     *
     * @var string
     */
    protected $document_middle_name;

    /**
     * Customer's last name
     *
     * @var string
     */
    protected $document_last_name;

    /**
     * Customer's full address
     *
     * @var string
     */
    protected $document_full_address;

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
     * Get Document Date Of Birth in the correct format
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
     * Set customer's first name
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setDocumentFirstName($value)
    {
        if (empty($value)) {
            $this->document_first_name = null;

            return $this;
        }

        return $this->setLimitedString(
            'document_first_name',
            $value,
            null,
            32
        );
    }

    /**
     * Set customer's middle name
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setDocumentMiddleName($value)
    {
        if (empty($value)) {
            $this->document_middle_name = null;

            return $this;
        }

        return $this->setLimitedString(
            'document_middle_name',
            $value,
            null,
            32
        );
    }

    /**
     * Set customer's last name
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setDocumentLastName($value)
    {
        if (empty($value)) {
            $this->document_last_name = null;

            return $this;
        }

        return $this->setLimitedString(
            'document_last_name',
            $value,
            null,
            32
        );
    }


    /**
     * Set customer's full address
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setDocumentFullAddress($value)
    {
        if (empty($value)) {
            $this->document_full_address = null;

            return $this;
        }

        return $this->setLimitedString(
            'document_full_address',
            $value,
            null,
            250
        );
    }

    /**
     * Build Identity Document structure
     *
     * @return array
     */
    protected function getIdentityDocumentStructure()
    {
        return [
            'proof'         => $this->document_proof,
            'date_of_birth' => $this->getDocumentDateOfBirth(),
            'first_name'    => $this->document_first_name,
            'middle_name'   => $this->document_middle_name,
            'last_name'     => $this->document_last_name,
            'full_address'  => $this->document_full_address
        ];
    }
}
