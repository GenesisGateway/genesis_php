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
namespace Genesis\API\Request\Financial\PayByVouchers;

/**
 * Class oBeP
 *
 * PayByVoucher oBeP transaction via YeePay
 *
 * @package Genesis\API\Request\Financial\PayByVouchers
 */
// @codingStandardsIgnoreStart
class oBeP extends \Genesis\API\Request
// @codingStandardsIgnoreEnd
{
    /**
     * Unique transaction id defined by mer-chant
     *
     * @var string
     */
    protected $transaction_id;

    /**
     * Card type for the voucher - can be ’virtual’ or ’physical’ only
     *
     * @var string
     */
    protected $card_type;

    /**
     * Redeem type for the voucher - can be ’stored’ or ’instant’ only
     *
     * @var string
     */
    protected $redeem_type;

    /**
     * IPv4 address of customer
     *
     * @var string
     */
    protected $remote_ip;

    /**
     * Apply to order product information in the process of payment
     * and the product description of purchase
     *
     * @var string
     */
    protected $product_name;

    /**
     * Type of commodity, includes:
     * - 3C digits,
     * - clothing and shoes,
     * - bag and accessories,
     * - books and DVDS,
     * - tuition,
     * - register exam tuition,
     * - member fee,
     * - participation fee,
     * - logistic service,
     * - airline tickets,
     * - hotel catering,
     * - etc...
     *
     * @var string
     */
    protected $product_category;

    /**
     * Amount of transaction in minor currency unit
     *
     * @var int
     */
    protected $amount;

    /**
     * Currency code in ISO-4217
     *
     * @var string
     */
    protected $currency;

    /**
     * Email address of the Customer
     *
     * @var string
     */
    protected $customer_email;

    /**
     * Full of customer in Chinese
     *
     * @var string
     */
    protected $customer_name;

    /**
     * Phone number of the customer
     *
     * @var string
     */
    protected $customer_phone;

    /**
     * Customer ID number.
     *
     * Must be a 18 digits valid IDCard number
     *
     * @var string
     */
    protected $customer_id_number;

    /**
     * Bank ID, see the table with bank id codes
     *
     * @var string
     */
    protected $customer_bank_id;

    /**
     * Bank identification number of customer.
     *
     * Must be a 16 or 19 digits valid bank account number
     *
     * @var string
     */
    protected $bank_account_number;

    /**
     * Set the per-request configuration
     *
     * @return void
     */
    protected function initConfiguration()
    {
        $this->initXmlConfiguration();

        $this->initApiGatewayConfiguration();
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
            'card_type',
            'redeem_type',
            'amount',
            'currency',
            'product_name',
            'product_category',
            'customer_name',
            'customer_email',
            'customer_phone',
            'customer_id_number',
            'customer_bank_id',
            'bank_account_number'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = [
            'payment_transaction' => [
                'transaction_type'    => \Genesis\API\Constants\Transaction\Types::PAYBYVOUCHER_YEEPAY,
                'transaction_id'      => $this->transaction_id,
                'card_type'           => $this->card_type,
                'redeem_type'         => $this->redeem_type,
                'remote_ip'           => $this->remote_ip,
                'amount'              => $this->transform(
                    'amount',
                    [
                        $this->amount,
                        $this->currency
                    ]
                ),
                'currency'            => $this->currency,
                'product_name'        => $this->product_name,
                'product_category'    => $this->product_category,
                'customer_name'       => $this->customer_name,
                'customer_email'      => $this->customer_email,
                'customer_phone'      => $this->customer_phone,
                'customer_id_number'  => $this->customer_id_number,
                'customer_bank_id'    => $this->customer_bank_id,
                'bank_account_number' => $this->bank_account_number
            ]
        ];

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }
}
