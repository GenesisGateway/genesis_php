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

namespace Genesis\Api\Request\Financial\CashPayments;

use Genesis\Api\Constants\Transaction\Parameters\CashPayments\CompanyTypes;
use Genesis\Api\Constants\Transaction\Parameters\CashPayments\Gender;
use Genesis\Api\Constants\Transaction\Parameters\CashPayments\MaritalStatuses;
use Genesis\Api\Constants\Transaction\Types;
use Genesis\Api\Request\Base\Financial;
use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\DocumentAttributes;
use Genesis\Api\Traits\Request\Financial\AsyncAttributes;
use Genesis\Api\Traits\Request\Financial\BirthDateAttributes;
use Genesis\Api\Traits\Request\Financial\CustomerAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Api\Traits\Request\Financial\PendingPaymentAttributes;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Pix
 * @package Genesis\Api\Request\Financial\CashPayments
 *
 * Pix is a payment service created by the Central Bank of Brazil (BACEN),
 * which represents a new way of receiving/sending money. Pix allows payments
 * to be made instantly. The customer can pay bills, invoices, public utilities,
 * transfer and receive credits in a facilitated manner, using only Pix keys (CPF/CNPJ).
 *
 * @method string  getTransactionId()
 * @method mixed   getAmount()
 * @method string  getCurrency()
 * @method string  getDocumentId()
 * @method int     getGender()
 * @method int     getMaritalStatus()
 * @method string  getSenderOccupation()
 * @method string  getNationality()
 * @method string  getCountryOfOrigin()
 * @method string  getBirthCity()
 * @method string  getBirthState()
 * @method $this   setTransactionId($value)
 * @method $this   setAmount($value)
 * @method $this   setCurrency($value)
 * @method $this   setDocumentId($documentId)
 * @method $this   setSenderOccupation($value)
 * @method $this   setNationality($value)
 * @method $this   setCountryOfOrigin($value)
 * @method $this   setBirthState($value)
 *
 */
class Pix extends Financial
{
    use AddressInfoAttributes;
    use AsyncAttributes;
    use BirthDateAttributes;
    use CustomerAttributes;
    use DocumentAttributes;
    use PaymentAttributes;
    use PendingPaymentAttributes;

    /**
     * Gender
     * 0 = Male, 1 = Female, 2 = Other
     *
     * @var $gender
     */
    protected $gender;

    /**
     * Marital status
     * 0 = NotMarried, 1 = Married, 2 = Divorced, 3 = Separate, 4 = Widower, 5 = Single, 6 = Other
     *
     * @var $marital_status
     */
    protected $marital_status;

    /**
     * Occupation of the recipient
     *
     * @var string $sender_occupation
     */
    protected $sender_occupation;

    /**
     * Nationality of the payer
     *
     * @var string $nationality
     */
    protected $nationality;

    /**
     * Country of origin of the payer. Two-letter iso codes
     *
     * @var string $country_of_origin
     */
    protected $country_of_origin;

    /**
     * City of birth of the payer
     *
     * @var string $birth_city
     */
    protected $birth_city;

    /**
     * Birth state of the payer
     *
     * @var string $birth_state
     */
    protected $birth_state;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return Types::PIX;
    }

    /**
     * Allowed Billing Countries
     *
     * @return array
     */
    protected function getAllowedBillingCountries()
    {
        return ['BR'];
    }

    /**
     * @param $value
     * @return Pix
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setGender($value)
    {
        return $this->allowedOptionsSetter(
            'gender',
            Gender::getAll(),
            $value,
            'Invalid value for parameter gender provided.'
        );
    }

    /**
     * @param $value
     * @return Pix
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setMaritalStatus($value)
    {
        return $this->allowedOptionsSetter(
            'marital_status',
            MaritalStatuses::getAll(),
            $value,
            'Invalid value for marital status parameter provided.'
        );
    }

    public function setCompanyType($value)
    {
        return $this->allowedOptionsSetter(
            'company_type',
            CompanyTypes::getAll(),
            $value,
            'Invalid value for company type parameter provided.'
        );
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_id',
            'amount',
            'currency',
            'document_id'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'billing_country' => $this->getAllowedBillingCountries()
        ];

        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);

        $this->requiredFieldValuesConditional = CommonUtils::createArrayObject(
            $this->getDocumentIdConditions()
        );
    }

    /**
     * Return additional request attributes
     *
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return array_merge(
            [
                'return_success_url' => $this->return_success_url,
                'return_failure_url' => $this->return_failure_url,
                'return_pending_url' => $this->getReturnPendingUrl(),
                'amount'             => $this->transformAmount($this->amount, $this->currency),
                'currency'           => $this->currency,
                'customer_email'     => $this->customer_email,
                'document_id'        => $this->document_id,
                'billing_address'    => $this->getBillingAddressParamsStructure(),
                'shipping_address'   => $this->getShippingAddressParamsStructure(),
                'birth_date'         => $this->getBirthDate(),
                'birth_city'         => $this->birth_city,
                'birth_state'        => $this->birth_state,
                'gender'             => $this->gender,
                'marital_status'     => $this->marital_status,
                'sender_occupation'  => $this->sender_occupation,
                'nationality'        => $this->nationality,
                'country_of_origin'  => $this->country_of_origin

            ],
            $this->getCustomerParamsStructure()
        );
    }
}
