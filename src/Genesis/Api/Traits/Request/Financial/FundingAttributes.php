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

namespace Genesis\Api\Traits\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\Funding\BusinessApplicationIdentifierTypes;
use Genesis\Api\Constants\Transaction\Parameters\Funding\IdentifierTypes;
use Genesis\Api\Constants\Transaction\Parameters\Funding\ReceiverAccountTypes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Country;

/**
 * Trait FundingAttributes
 * @package Genesis\Api\Traits\Request\Financial
 *
 * @method string getFundingIdentifierType()
 * @method $this  setFundingReceiverFirstName($value)
 * @method string getFundingReceiverFirstName()
 * @method $this  setFundingReceiverLastName($value)
 * @method string getFundingReceiverLastName()
 * @method string getFundingReceiverCountry()
 * @method $this  setFundingReceiverAccountNumber($value)
 * @method string getFundingReceiverAccountNumber()
 * @method string getFundingReceiverAccountNumberType()
 * @method string getFundingBusinessApplicationIdentifier()
 * @method $this  setFundingReceiverAddress($value)
 * @method string getFundingReceiverAddress()
 * @method $this  setFundingReceiverState($value)
 * @method string getFundingReceiverState()
 * @method $this  setFundingReceiverCity($value)
 * @method string getFundingReceiverCity()
 * @method $this  setFundingSenderName($value)
 * @method string getFundingSenderName()
 * @method $this  setFundingSenderReferenceNumber($value)
 * @method string getFundingSenderReferenceNumber()
 * @method string getFundingSenderCountry()
 * @method $this  setFundingSenderAddress($value)
 * @method string getFundingSenderAddress()
 * @method $this  setFundingSenderState($value)
 * @method string getFundingSenderState()
 * @method $this  setFundingSenderCity($value)
 * @method string getFundingSenderCity()
 *
 */
trait FundingAttributes
{
    /**
     * Type of Funding Transaction
     *
     * @var string
     */
    protected $funding_identifier_type;

    /**
     * First name of the receiver
     *
     * @var string
     */
    protected $funding_receiver_first_name;

    /**
     * Last name of the receiver
     *
     * @var string
     */
    protected $funding_receiver_last_name;

    /**
     * Country code in ISO 3166
     *
     * @var string
     */
    protected $funding_receiver_country;

    /**
     * Receiver account number
     *
     * @var string
     */
    protected $funding_receiver_account_number;

    /**
     * Receiver account number type.
     *
     * @var string
     */
    protected $funding_receiver_account_number_type;

    /**
     * Business application identifier
     *
     * @var string
     */
    protected $funding_business_application_identifier;

    /**
     * Receiver address
     *
     * @var string
     */
    protected $funding_receiver_address;

    /**
     * Receiver state
     *
     * @var string
     */
    protected $funding_receiver_state;

    /**
     * Receiver city
     *
     * @var string
     */
    protected $funding_receiver_city;

    /**
     * Sender name
     *
     * @var string
     */
    protected $funding_sender_name;

    /**
     * Sender reference number
     *
     * @var string
     */
    protected $funding_sender_reference_number;

    /**
     * Sender country
     *
     * @var string
     */
    protected $funding_sender_country;

    /**
     * Sender address
     *
     * @var string
     */
    protected $funding_sender_address;

    /**
     * Sender state
     *
     * @var string
     */
    protected $funding_sender_state;

    /**
     * Sender city
     *
     * @var string
     */
    protected $funding_sender_city;

    /**
     * Validate funding_identifier_type param
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setFundingIdentifierType($value)
    {
        return $this->allowedOptionsSetter(
            'funding_identifier_type',
            IdentifierTypes::getAll(),
            $value,
            'Parameter Funding Identifier Type not valid!'
        );
    }

    /**
     * Validate funding_receiver_account_number_type param
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setFundingReceiverAccountNumberType($value)
    {
        return $this->allowedOptionsSetter(
            'funding_receiver_account_number_type',
            ReceiverAccountTypes::getAll(),
            $value,
            'Parameter Funding Receiver Account Number Type not valid!'
        );
    }

    /**
     * Validate funding_receiver_country param
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setFundingReceiverCountry($value)
    {
        return $this->allowedOptionsSetter(
            'funding_receiver_country',
            Country::getList(),
            $value,
            'Parameter Funding Receiver Country not valid!'
        );
    }

    /**
     * Validate funding_business_application_identifier param
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setFundingBusinessApplicationIdentifier($value)
    {
        return $this->allowedOptionsSetter(
            'funding_business_application_identifier',
            BusinessApplicationIdentifierTypes::getAll(),
            $value,
            'Parameter Funding Business Application Identifier not valid!'
        );
    }

    /**
     * Validate funding_receiver_country param
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setFundingSenderCountry($value)
    {
        return $this->allowedOptionsSetter(
            'funding_sender_country',
            Country::getList(),
            $value,
            'Parameter Funding Sender Country not valid!'
        );
    }

    /**
     * Get Funding Attributes structure
     *
     * @return array
     */
    protected function getFundingAttributesStructure()
    {
        return [
            'identifier_type'                 => $this->funding_identifier_type,
            'business_application_identifier' => $this->funding_business_application_identifier,
            'receiver'                        => [
                'first_name'          => $this->funding_receiver_first_name,
                'last_name'           => $this->funding_receiver_last_name,
                'country'             => $this->funding_receiver_country,
                'account_number'      => $this->funding_receiver_account_number,
                'account_number_type' => $this->funding_receiver_account_number_type,
                'address'             => $this->funding_receiver_address,
                'state'               => $this->funding_receiver_state,
                'city'                => $this->funding_receiver_city,
            ],
            'sender'                          => [
                'name'             => $this->funding_sender_name,
                'reference_number' => $this->funding_sender_reference_number,
                'country'          => $this->funding_sender_country,
                'address'          => $this->funding_sender_address,
                'state'            => $this->funding_sender_state,
                'city'             => $this->funding_sender_city
            ]
        ];
    }
}
