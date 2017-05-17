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

namespace Genesis\API\Request\Financial\OnlineBankingPayments\iDebit;

use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;

/**
 * Class Payin
 *
 * iDebit Payin - Online Banking ePayments (oBeP)
 *
 * @package Genesis\API\Request\Financial\OnlineBankingPayments\iDebit
 *
 * @method Payin setCustomerAccountId($value) Set Unique consumer account ID
 * @method Payin setReturnUrl($value) Set the URL where customer is sent to after payment
 */
class Payin extends \Genesis\API\Request\Base\Financial
{
    use PaymentAttributes, AddressInfoAttributes;

    /**
     * Unique consumer account ID
     *
     * @var string
     */
    protected $customer_account_id;

    /**
     * URL where customer is sent to after payment
     *
     * @var string
     */
    protected $return_url;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::IDEBIT_PAYIN;
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
            'return_url',
            'customer_account_id',
            'billing_country'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'billing_country' => ['CA'],
            'currency'        => ['CAD', 'USD', 'EUR', 'GBP', 'AUD']
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
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
            'customer_account_id' => $this->customer_account_id,
            'return_url'          => $this->return_url,
            'customer_email'      => $this->customer_email,
            'customer_phone'      => $this->customer_phone,
            'billing_address'     => $this->getBillingAddressParamsStructure(),
            'shipping_address'    => $this->getShippingAddressParamsStructure()
        ];
    }
}
