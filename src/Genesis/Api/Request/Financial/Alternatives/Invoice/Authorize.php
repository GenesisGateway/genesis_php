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

namespace Genesis\Api\Request\Financial\Alternatives\Invoice;

use Genesis\Api\Constants\Financial\Alternative\Invoice\PaymentMethodCategories;
use Genesis\Api\Constants\Financial\Alternative\Invoice\PaymentTypes;
use Genesis\Api\Constants\Transaction\Types;
use Genesis\Api\Request\Base\Financial\Alternative\Invoice;
use Genesis\Api\Request\Financial\Alternatives\Transaction\Items;
use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\Financial\Alternatives\Invoice\InvoiceValidation;
use Genesis\Api\Traits\Request\Financial\AsyncAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Exceptions\InvalidClassMethod;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Authorize
 *
 * Alternative payment method
 *
 * Handles the authorization request for invoice payments.
 *
 * @package Genesis\Api\Request\Financial\Alternatives\Invoice
 *
 * @method void   setPaymentMethodCategory(string $value)   Set the payment method category
 *   (e.g., 'pay_later', 'pay_over_time')
 * @method void   setCustomerGender(string $value)          Set the customer's gender (e.g., 'male', 'female', 'other')
 * @method void   setCustomerBirthdate(string $value)       Set the customer's birthdate in 'YYYY-MM-DD' format
 * @method void   setCustomerReferenceNumber(string $value) Set the customer's reference number for the transaction
 * @method string getPaymentMethodCategory()                Get the payment method category
 * @method string getCustomerGender()                       Get the customer's gender
 * @method string getCustomerBirthdate()                    Get the customer's birthdate
 * @method string getCustomerReferenceNumber()              Get the customer's reference number for the transaction
*/
class Authorize extends Invoice
{
    use AddressInfoAttributes;
    use AsyncAttributes;
    use PaymentAttributes;
    use InvoiceValidation;

    /**
     * Payment method category: either pay_over_time or pay_later
     *
     * @var string
     */
    protected $payment_method_category;

    /**
     * Customer's gender
     *
     * @var string
     */
    protected $customer_gender;

    /**
     * Customer date of birth, required for Secure Invoice
     *
     * @var string
     */
    protected $customer_birthdate;

    /**
     * Customer reference number, required for Secure Invoice
     *
     * @var string
     */
    protected $customer_reference_number;

    /**
     * Authorize constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->items = new Items();
    }

    /**
     * Return transaction type
     *
     * @return string
     */
    protected function getTransactionType()
    {
        return Types::INVOICE;
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
            'return_success_url',
            'return_failure_url',
            'payment_type',
            'payment_method_category',
            'billing_country',
            'shipping_country'
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldsConditional = [
            'payment_type' => [
                PaymentTypes::SECURE_INVOICE => [
                    'customer_birthdate',
                    'customer_reference_number'
                ]
            ]
        ];
        $this->requiredFieldsConditional = CommonUtils::createArrayObject($requiredFieldsConditional);

        $requiredFieldValues = [
            'payment_type'            => PaymentTypes::getAll(),
            'payment_method_category' => PaymentMethodCategories::getAll(),
            'currency'                => ['EUR', 'DKK', 'NOK', 'SEK'],
            'billing_country'         => ['AT', 'DK', 'FI', 'DE', 'NL', 'NO', 'SE'],
            'shipping_country'        => ['AT', 'DK', 'FI', 'DE', 'NL', 'NO', 'SE']
        ];
        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }

    /**
     * Perform field validation
     *
     * @return void
     *
     * @throws ErrorParameter
     * @throws InvalidArgument
     * @throws InvalidClassMethod
     */
    protected function checkRequirements()
    {
        parent::checkRequirements();

        $this->validateItems();
        $this->validateAmount();
    }

    /**
     * Return additional request attributes
     *
     * @return array
     *
     * @throws InvalidArgument
     */
    protected function getPaymentTransactionStructure()
    {
        $this->items->setCurrency($this->currency);

        return array_merge(
            parent::getPaymentTransactionStructure(),
            [
                'payment_type'              => $this->payment_type,
                'payment_method_category'   => $this->payment_method_category,
                'billing_address'           => $this->getBillingAddressParamsStructure(),
                'shipping_address'          => $this->getShippingAddressParamsStructure(),
                'return_success_url'        => $this->return_success_url,
                'return_failure_url'        => $this->return_failure_url,
                'customer_gender'           => $this->customer_gender,
                'customer_birthdate'        => $this->customer_birthdate,
                'customer_reference_number' => $this->customer_reference_number,
                'customer_email'            => $this->customer_email
            ]
        );
    }
}
