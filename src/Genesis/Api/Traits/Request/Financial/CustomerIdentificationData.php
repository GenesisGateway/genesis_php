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

namespace Genesis\Api\Traits\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\CustomerIdentification\CustomerIdentificationOwner;
use Genesis\Api\Constants\Transaction\Parameters\CustomerIdentification\CustomerIdentificationSubType;
use Genesis\Api\Constants\Transaction\Parameters\CustomerIdentification\CustomerIdentificationType;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Country;

/**
 * trait CustomerIdentificationData
 *
 * @package Genesis\Api\Traits\Request\Financial
 *
 * @method $this setCustomerIdentificationDocumentId($id) Document ID
 */
trait CustomerIdentificationData
{
    /**
     * The owner of the document ID
     *
     * @var string
     */
    protected $customer_identification_owner;

    /**
     * The type of the document
     *
     * @var string
     */
    protected $customer_identification_type;

    /**
     * The subtype of the document
     *
     * @var string
     */
    protected $customer_identification_subtype;

    /**
     * Document ID value
     *
     * @var string
     */
    protected $customer_identification_document_id;

    /**
     * The issuing country of the document
     *
     * @var string
     */
    protected $customer_identification_issuing_country;


    /**
     * Set the correct owner of the document
     *
     * @param string $owner
     * @return $this
     * @throws InvalidArgument
     */
    public function setCustomerIdentificationOwner($owner)
    {
        if (empty($owner)) {
            $this->customer_identification_owner = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'customer_identification_owner',
            CustomerIdentificationOwner::getAll(),
            $owner,
            sprintf(
                'Invalid data for %s.',
                'Customer Identification Document Owner'
            )
        );
    }

    /**
     * Set the correct type of the customer identification document
     *
     * @param string $type
     * @return $this
     * @throws InvalidArgument
     */
    public function setCustomerIdentificationType($type)
    {
        if (empty($type)) {
            $this->customer_identification_type = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'customer_identification_type',
            CustomerIdentificationType::getAll(),
            $type,
            sprintf(
                'Invalid data for %s',
                'Customer Identification Document Type'
            )
        );
    }

    /**
     * Set the country where the document is issued. Check for ISO validity
     *
     * @param $country
     * @return $this
     * @throws InvalidArgument
     */
    public function setCustomerIdentificationIssuingCountry($country)
    {
        if (empty($country)) {
            $this->customer_identification_issuing_country = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'customer_identification_issuing_country',
            Country::getList(),
            $country,
            sprintf(
                'Invalid country code for %s',
                'Document issuer country'
            )
        );
    }

    /**
     * Set the correct subtype of the customer identification document
     *
     * @param string $subtype
     * @return $this
     * @throws InvalidArgument
     */
    public function setCustomerIdentificationSubtype($subtype)
    {
        if (empty($subtype)) {
            $this->customer_identification_subtype = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'customer_identification_subtype',
            CustomerIdentificationSubType::getAll(),
            $subtype,
            sprintf(
                'Invalid value for %s.',
                'Customer Identification Document Subtype'
            )
        );
    }

    /**
     * Return Customer Identification Data structure
     *
     * @return array
     */
    protected function getCustomerIdentificationDataStructure()
    {
        return [
            'owner'           => $this->customer_identification_owner,
            'type'            => $this->customer_identification_type,
            'subtype'         => $this->customer_identification_subtype,
            'document_id'     => $this->customer_identification_document_id,
            'issuing_country' => $this->customer_identification_issuing_country,
        ];
    }
}
