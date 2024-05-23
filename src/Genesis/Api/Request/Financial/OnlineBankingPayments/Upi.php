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

namespace Genesis\Api\Request\Financial\OnlineBankingPayments;

use Genesis\Api\Constants\Transaction\Types;
use Genesis\Api\Request\Base\Financial;
use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\DocumentAttributes;
use Genesis\Api\Traits\Request\Financial\AsyncAttributes;
use Genesis\Api\Traits\Request\Financial\OnlineBankingPayments\UserCategoryAttributes;
use Genesis\Api\Traits\Request\Financial\OnlineBankingPayments\VirtualPaymentAddressAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

class Upi extends Financial
{
    use AddressInfoAttributes;
    use AsyncAttributes;
    use DocumentAttributes;
    use PaymentAttributes;
    use UserCategoryAttributes;
    use VirtualPaymentAddressAttributes;

    /**
     * Return the Transaction Type used by Genesis
     *
     * @return string
     */
    protected function getTransactionType()
    {
        return Types::UPI;
    }

    /**
     * Fields Validation
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_id',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'virtual_payment_address',
            'billing_country'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'currency' => [ 'INR' ]
        ];

        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }

    /**
     * Add document_id conditional validation if it is present
     *
     * @return void
     * @throws InvalidArgument
     * @throws \Genesis\Exceptions\ErrorParameter
     * @throws \Genesis\Exceptions\InvalidClassMethod
     */
    protected function checkRequirements()
    {
        if ($this->document_id) {
            $this->requiredFieldValuesConditional = CommonUtils::createArrayObject(
                $this->getDocumentIdConditions()
            );
        }

        parent::checkRequirements();
    }

    /**
     * Return additional request attributes
     *
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'return_success_url'      => $this->return_success_url,
            'return_failure_url'      => $this->return_failure_url,
            'amount'                  => $this->transformAmount($this->amount, $this->currency),
            'currency'                => $this->currency,
            'customer_email'          => $this->customer_email,
            'customer_phone'          => $this->customer_phone,
            'document_id'             => $this->document_id,
            'virtual_payment_address' => $this->virtual_payment_address,
            'user_category'           => $this->user_category,
            'billing_address'         => $this->getBillingAddressParamsStructure(),
            'shipping_address'        => $this->getShippingAddressParamsStructure()
        ];
    }
}
