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
     * @throws ErrorParameter
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
     * Get Funding Attributes structure
     *
     * @return array
     */
    protected function getFundingAttributesStructure()
    {
        return [
            'identifier_type'         => $this->funding_identifier_type,
            'receiver'                => [
                'first_name'          => $this->funding_receiver_first_name,
                'last_name'           => $this->funding_receiver_last_name,
                'country'             => $this->funding_receiver_country,
                'account_number'      => $this->funding_receiver_account_number,
                'account_number_type' => $this->funding_receiver_account_number_type
            ]
        ];
    }
}
