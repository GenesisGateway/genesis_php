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

namespace Genesis\Api\Request\Financial\Alternatives;

use Genesis\Api\Constants\Payment\Methods as PaymentMethods;
use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\Financial\AsyncAttributes;
use Genesis\Api\Traits\Request\Financial\BankAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Api\Traits\Request\Financial\PendingPaymentAttributes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Ppro
 *
 * Alternative payment method
 *
 * @package Genesis\Api\Request\Financial\Alternatives
 *
 * @method Ppro setPaymentType($value) Set used payment type
 * @method Ppro setAccountNumber($value) Set valid account number
 * @method Ppro setBankCode($value) Set a valid bank code
 * @method Ppro setBic($value) Set a valid BIC
 * @method Ppro setIban($value) Set a valid IBAN bank account
 * @method Ppro setAccountPhone($value) Set phone number for destination account to pay out
 */
class Ppro extends \Genesis\Api\Request\Base\Financial
{
    use AddressInfoAttributes;
    use AsyncAttributes;
    use BankAttributes;
    use PaymentAttributes;
    use PendingPaymentAttributes;

    /**
     * Used payment method
     *
     * @var string
     */
    protected $payment_type;

    /**
     * Must contain valid account number, check:
     *
     * "PPRO Payment Method Requirements"
     *
     * in the official API documentation
     *
     * @var string
     */
    protected $account_number;

    /**
     * Must contain valid bank code, check:
     *
     * "PPRO Payment Method Requirements"
     *
     * in the official API documentation
     *
     * @var string
     */
    protected $bank_code;

    /**
     * Must contain valid phone number for destination account to pay out, check:
     *
     * "PPRO Payment Method Requirements"
     *
     * in the official API documentation
     *
     * @var string
     */
    protected $account_phone;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\Api\Constants\Transaction\Types::PPRO;
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
            'remote_ip',
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url',
            'customer_email',
            'billing_country'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'payment_type'    => PaymentMethods::getMethods(),
            'billing_country' => \Genesis\Utils\Country::getList(),
            'currency'        => \Genesis\Utils\Currency::getList()
        ];

        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);

        $requiredFieldsConditional = [
            'payment_type' => [
                PaymentMethods::PRZELEWY24 => [
                    'customer_email'
                ]
            ]
        ];

        $this->requiredFieldsConditional = CommonUtils::createArrayObject($requiredFieldsConditional);

        $this->setRequiredFieldValuesConditional();
    }

    /**
     * Set the required fields - conditionally depending on other fields
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function setRequiredFieldValuesConditional()
    {
        $requiredFieldValuesConditional = [
            'payment_type' => [
                PaymentMethods::EPS        => [
                    [
                        'billing_country' => 'AT',
                        'currency'        => 'EUR'
                    ]
                ],
                PaymentMethods::SAFETY_PAY => [
                    [
                        'billing_country' => [
                            'AT', 'BE', 'BR', 'CL', 'CO', 'DE', 'EC', 'ES', 'MX', 'NL', 'PE', 'PR'
                        ],
                        'currency'        => ['EUR', 'USD']
                    ]
                ],
                PaymentMethods::PRZELEWY24 => [
                    [
                        'billing_country' => 'PL',
                        'currency'        => 'PLN'
                    ]
                ],
                PaymentMethods::IDEAL      => [
                    [
                        'billing_country' => 'NL',
                        'currency'        => 'EUR'
                    ]
                ],
                PaymentMethods::BCMC       => [
                    [
                        'billing_country' => 'BE',
                        'currency'        => 'EUR'
                    ]
                ],
                PaymentMethods::MYBANK     => [
                    [
                        'billing_country' => ['IT'],
                        'currency'        => 'EUR'
                    ]
                ]
            ]
        ];

        $this->requiredFieldValuesConditional = CommonUtils::createArrayObject($requiredFieldValuesConditional);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'payment_type'       => $this->payment_type,
            'amount'             => $this->transformAmount($this->amount, $this->currency),
            'currency'           => $this->currency,
            'return_success_url' => $this->return_success_url,
            'return_failure_url' => $this->return_failure_url,
            'return_pending_url' => $this->getReturnPendingUrl(),
            'customer_email'     => $this->customer_email,
            'customer_phone'     => $this->customer_phone,
            'account_number'     => $this->account_number,
            'bank_code'          => $this->bank_code,
            'bic'                => $this->bic,
            'iban'               => $this->iban,
            'account_phone'      => $this->account_phone,
            'billing_address'    => $this->getBillingAddressParamsStructure(),
            'shipping_address'   => $this->getShippingAddressParamsStructure()
        ];
    }
}
