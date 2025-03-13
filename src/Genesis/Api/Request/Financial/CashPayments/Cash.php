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

namespace Genesis\Api\Request\Financial\CashPayments;

use Genesis\Api\Constants\Transaction\Types;
use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\Financial\AsyncAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Api\Constants\Transaction\Parameters\CashPayments\CashPaymentTypes;
use Genesis\Api\Request\Base\Financial;
use Genesis\Api\Traits\Request\DocumentAttributes;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Cash
 *
 * Implements the API call for Cash payment method.
 *
 * @method string getPaymentType()       Get the payment type
 * @method $this  setPaymentType($value) Set the payment type
 *
 * @package Genesis\Api\Request\Financial\CashPayments
 */
class Cash extends Financial
{
    use AddressInfoAttributes;
    use AsyncAttributes;
    use DocumentAttributes;
    use PaymentAttributes;

    /**
     * @var string $payment_type
     */
    protected $payment_type;

    /**
     * Get the transaction type.
     *
     * @return string
     */
    protected function getTransactionType()
    {
        return Types::CASH;
    }

    /**
     * Set the required fields for the transaction.
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_id',
            'remote_ip',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'payment_type',
            'document_id'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'currency'        => ['MXN'],
            'payment_type'    => CashPaymentTypes::getAll()
        ];

        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);

        $this->requiredFieldValuesConditional = CommonUtils::createArrayObject(
            $this->getDocumentIdConditions()
        );
    }

    /**
     * Get the structure of the payment transaction.
     *
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
                'return_success_url' => $this->return_success_url,
                'return_failure_url' => $this->return_failure_url,
                'amount'             => $this->transformAmount($this->amount, $this->currency),
                'currency'           => $this->currency,
                'customer_email'     => $this->customer_email,
                'customer_phone'     => $this->customer_phone,
                'payment_type'       => $this->payment_type,
                'document_id'        => $this->document_id,
                'billing_address'    => $this->getBillingAddressParamsStructure()
            ];
    }
}
