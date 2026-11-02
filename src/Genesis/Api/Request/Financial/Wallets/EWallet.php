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
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Request\Financial\Wallets;

use Genesis\Api\Constants\Transaction\Parameters\Wallets\EWallet\PaymentTypes;
use Genesis\Api\Constants\Transaction\Types;
use Genesis\Api\Request\Base\Financial;
use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\Financial\AsyncAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class EWallet
 *
 * eWallet - asynchronous payment method routing the payment to an Indian e-wallet provider
 *
 * @package Genesis\Api\Request\Financial\Wallets
 *
 * @method string getPaymentType()
 * @method $this  setPaymentType($value)
 */
class EWallet extends Financial
{
    use AddressInfoAttributes;
    use AsyncAttributes;
    use PaymentAttributes;

    /**
     * eWallet provider used for the payment
     *
     * @var string
     */
    protected $payment_type;

    /**
     * Set the URL where the customer is sent to after successful payment
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setReturnSuccessUrl($value)
    {
        return $this->setValidUrl('return_success_url', $value);
    }

    /**
     * Set the URL where the customer is sent to after un-successful payment
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setReturnFailureUrl($value)
    {
        return $this->setValidUrl('return_failure_url', $value);
    }

    /**
     * Return the Transaction Type used by Genesis
     *
     * @return string
     */
    protected function getTransactionType()
    {
        return Types::E_WALLET;
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
            'payment_type',
            'amount',
            'currency',
            'remote_ip',
            'customer_email',
            'customer_phone',
            'return_success_url',
            'return_failure_url',
            'billing_country'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'currency'     => ['INR'],
            'payment_type' => PaymentTypes::getAllowedPaymentTypes()
        ];

        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);

        $requiredFieldsConditional = [
            'billing_country' => [
                'US' => ['billing_state'],
                'CA' => ['billing_state']
            ]
        ];

        $this->requiredFieldsConditional = CommonUtils::createArrayObject($requiredFieldsConditional);
    }

    /**
     * Return additional request attributes
     *
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'payment_type'       => $this->payment_type,
            'amount'             => $this->transformAmount($this->amount, $this->currency),
            'currency'           => $this->currency,
            'customer_email'     => $this->customer_email,
            'customer_phone'     => $this->customer_phone,
            'return_success_url' => $this->return_success_url,
            'return_failure_url' => $this->return_failure_url,
            'billing_address'    => $this->getBillingAddressParamsStructure(),
            'shipping_address'   => $this->getShippingAddressParamsStructure()
        ];
    }

    /**
     * Validate and set an URL attribute
     *
     * An empty value clears the attribute, so the required field check reports it as missing
     *
     * @param string $field
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    private function setValidUrl($field, $value)
    {
        if (empty($value)) {
            $this->{$field} = null;

            return $this;
        }

        if (!CommonUtils::isValidUrl($value)) {
            throw new InvalidArgument("Invalid $field URL is given.");
        }

        $this->{$field} = $value;

        return $this;
    }
}
