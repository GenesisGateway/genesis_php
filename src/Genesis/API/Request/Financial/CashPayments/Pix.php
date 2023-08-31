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
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Request\Financial\CashPayments;

use Genesis\API\Constants\Transaction\Types;
use Genesis\API\Request\Base\Financial;
use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\DocumentAttributes;
use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Pix
 * @package Genesis\API\Request\Financial\CashPayments
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
 * @method $this   setTransactionId($value)
 * @method $this   setAmount($value)
 * @method $this   setCurrency($value)
 * @method $this   setDocumentId($documentId)
 *
 */
class Pix extends Financial
{
    use AsyncAttributes, PaymentAttributes, AddressInfoAttributes, DocumentAttributes;

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
        return [
            'return_success_url' => $this->return_success_url,
            'return_failure_url' => $this->return_failure_url,
            'amount'             => $this->transformAmount($this->amount, $this->currency),
            'currency'           => $this->currency,
            'customer_email'     => $this->customer_email,
            'document_id'        => $this->document_id,
            'billing_address'    => $this->getBillingAddressParamsStructure(),
            'shipping_address'   => $this->getShippingAddressParamsStructure(),
        ];
    }
}
