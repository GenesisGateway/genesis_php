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

namespace Genesis\API\Request\Financial\Alternatives;

use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\AddressInfoAttributes;

/**
 * Class INPay
 *
 * Alternative payment method
 *
 * @package Genesis\API\Request\Financial\Alternatives
 *
 * @method INPay setCustomerBankId($value) The Bank ID of the selected bank from the Getbanks Request
 * @method INPay setOrderDescription($value) The a short description of the order
 * @method INPay setPayoutOrderId($value) Set an Order ID to relate this Payout to an Order
 * @method INPay setPayoutBankCountry($value) Set Country of the refund targets Bank Account 2-letter country code
 * @method INPay setPayoutBankName($value) Set Refund targets Bank Name
 * @method INPay setPayoutSwift($value) Set SWIFT/BIC Code
 * @method INPay setPayoutAccNumber($value) Set Account number or IBAN
 * @method INPay setPayoutBankAddress($value) Set Bank address
 * @method INPay setPayoutOwnerName($value) Set Bank account owner name
 * @method INPay setPayoutOwnerAddress($value) Set Bank account owner address
 */
class INPay extends \Genesis\API\Request\Base\Financial
{
    use AsyncAttributes, PaymentAttributes, AddressInfoAttributes;

    /**
     * Flag for payout transaction
     *
     * @var string
     */
    protected $is_payout;

    /**
     * The Bank ID of the selected bank from the Getbanks Request
     * @var string
     */
    protected $customer_bank_id;

    /**
     * A short description of the order
     * @var string
     */
    protected $order_description;

    /**
     * Order ID to relate this Payout to an Order
     * @var string
     */
    protected $payout_order_id;

    /**
     * Country of the refund targets Bank Ac- count 2-letter country code
     * ISO 3166-1
     * @var string
     */
    protected $payout_bank_country;

    /**
     * Refund targets Bank Name
     * @var string
     */
    protected $payout_bank_name;

    /**
     * SWIFT/BIC Code
     * @var string
     */
    protected $payout_swift;

    /**
     * Account number or IBAN
     * @var string
     */
    protected $payout_acc_number;

    /**
     * Bank address
     * @var string
     */
    protected $payout_bank_address;

    /**
     * Bank account owner name
     * @var string
     */
    protected $payout_owner_name;

    /**
     * Bank account owner address
     * @var string
     */
    protected $payout_owner_address;

    /**
     * INPay constructor
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
        return \Genesis\API\Constants\Transaction\Types::INPAY;
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
                false => [
                    'customer_bank_id',
                    'order_description'
                ],
                true  => [
                    'payout_order_id',
                    'payout_bank_country',
                    'payout_bank_name',
                    'payout_swift',
                    'payout_acc_number',
                    'payout_bank_address',
                    'payout_owner_name',
                    'payout_owner_address'
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
            'return_success_url'   => $this->return_success_url,
            'return_failure_url'   => $this->return_failure_url,
            'amount'               => $this->transformAmount($this->amount, $this->currency),
            'currency'             => $this->currency,
            'is_payout'            => var_export($this->is_payout, true),
            'customer_bank_id'     => $this->customer_bank_id,
            'order_description'    => $this->order_description,
            'payout_order_id'      => $this->payout_order_id,
            'payout_bank_country'  => $this->payout_bank_country,
            'payout_bank_name'     => $this->payout_bank_name,
            'payout_swift'         => $this->payout_swift,
            'payout_acc_number'    => $this->payout_acc_number,
            'payout_bank_address'  => $this->payout_bank_address,
            'payout_owner_name'    => $this->payout_owner_name,
            'payout_owner_address' => $this->payout_owner_address,
            'customer_email'       => $this->customer_email,
            'customer_phone'       => $this->customer_phone,
            'billing_address'      => $this->getBillingAddressParamsStructure(),
            'shipping_address'     => $this->getShippingAddressParamsStructure()
        ];
    }
}
