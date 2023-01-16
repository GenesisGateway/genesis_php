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

namespace Genesis\API\Request\Financial\Wallets;

use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\AddressInfoAttributes;

/**
 * Class WebMoney
 *
 * Electronic Wallet
 *
 * @package Genesis\API\Request\Financial\Wallets
 *
 * @method WebMoney setCustomerAccountId($value) Set Webmoney account ID (WMID)
 */
class WebMoney extends \Genesis\API\Request\Base\Financial
{
    use PaymentAttributes, AsyncAttributes, AddressInfoAttributes;

    /**
     * Flag for payout transaction
     *
     * @var bool
     */
    protected $is_payout;

    /**
     * Webmoney account ID (WMID)
     *
     * @var string
     */
    protected $customer_account_id;

    /**
     * WebMoney constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->setIsPayout(false);
    }

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::WEBMONEY;
    }

    /**
     * Set Flag for payout transaction
     * @param bool|int|string $value
     * @return $this
     */
    public function setIsPayout($value)
    {
        $this->is_payout = filter_var($value, FILTER_VALIDATE_BOOLEAN);

        return $this;
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
            'remote_ip',
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url',
            'customer_email',
            'billing_country'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'billing_country' => \Genesis\Utils\Country::getList(),
            'currency'        => \Genesis\Utils\Currency::getList()
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
        
        $requiredFieldsConditional = [
            'is_payout' => [
                true => [
                    'customer_account_id'
                ]
            ]
        ];

        $this->requiredFieldsConditional = \Genesis\Utils\Common::createArrayObject($requiredFieldsConditional);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'return_success_url'  => $this->return_success_url,
            'return_failure_url'  => $this->return_failure_url,
            'amount'              => $this->transformAmount($this->amount, $this->currency),
            'currency'            => $this->currency,
            'is_payout'           => var_export($this->is_payout, true),
            'customer_account_id' => $this->customer_account_id,
            'customer_email'      => $this->customer_email,
            'customer_phone'      => $this->customer_phone,
            'billing_address'     => $this->getBillingAddressParamsStructure(),
            'shipping_address'    => $this->getShippingAddressParamsStructure()
        ];
    }
}
