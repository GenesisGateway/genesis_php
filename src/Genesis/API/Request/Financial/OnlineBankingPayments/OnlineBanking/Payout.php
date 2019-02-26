<?php
/*
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
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking;

use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Validators\Request\RegexValidator;

/**
 * Class Payout
 *
 * OnlineBanking Payout - oBeP-style alternative payment method
 *
 * @package Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking
 *
 * @method Payout setBankAccountName($value) Set Customer’s bank account name
 * @method Payout setBankAccountNumber($value) Set Customer’s bank account number
 * @method Payout setBankName($value) Set Customer’s bank name
 * @method Payout setBankCode($value) Set Customer’s bank code
 * @method Payout setBankBranch($value) Set Customer’s bank branch
 */
class Payout extends \Genesis\API\Request\Base\Financial
{
    use AddressInfoAttributes, AsyncAttributes, PaymentAttributes;

    /**
     * Customer’s bank account name
     *
     * @var string
     */
    protected $bank_account_name;

    /**
     * Customer’s bank account number
     *
     * @var string
     */
    protected $bank_account_number;

    /**
     * Customer’s bank name
     *
     * @var string
     */
    protected $bank_name;

    /**
     * Customer’s bank ode
     *
     * @var string
     */
    protected $bank_code;

    /**
     * Customer’s bank branch
     *
     * @var string
     */
    protected $bank_branch;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::ONLINE_BANKING_PAYOUT;
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
            'remote_ip',
            'bank_account_name',
            'bank_account_number',
            'billing_first_name',
            'billing_last_name',
            'billing_state',
            'billing_country'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'currency' => [
                'CNY', 'THB', 'IDR'
            ]
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);

        $this->setRequiredFieldsConditional();
    }

    /**
     * Set the required fields conditional
     *
     * @return void
     */
    protected function setRequiredFieldsConditional()
    {
        $requiredFieldsConditional = [
            'currency' => [
                'IDR' => ['bank_code'],
                'CNY' => ['bank_branch', 'bank_name'],
                'THB' => ['bank_name']
            ]
        ];

        $this->requiredFieldsConditional = \Genesis\Utils\Common::createArrayObject($requiredFieldsConditional);

        $requiredFieldValuesConditional = [
            'currency' => [
                'CNY' => [
                    [
                        'bank_account_number' => new RegexValidator('/^[0-9]{19}$/')
                    ]
                ]
            ]
        ];

        $this->requiredFieldValuesConditional = \Genesis\Utils\Common::createArrayObject($requiredFieldValuesConditional);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'amount'              => $this->transformAmount($this->amount, $this->currency),
            'currency'            => $this->currency,
            'customer_email'      => $this->customer_email,
            'customer_phone'      => $this->customer_phone,
            'return_success_url'  => $this->return_success_url,
            'return_failure_url'  => $this->return_failure_url,
            'bank_code'           => $this->bank_code,
            'bank_name'           => $this->bank_name,
            'bank_branch'         => $this->bank_branch,
            'bank_account_name'   => $this->bank_account_name,
            'bank_account_number' => $this->bank_account_number,
            'billing_address'     => $this->getBillingAddressParamsStructure(),
            'shipping_address'    => $this->getShippingAddressParamsStructure()
        ];
    }
}
