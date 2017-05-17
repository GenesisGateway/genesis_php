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
 * Class Sofort
 *
 * Alternative payment method
 *
 * @package Genesis\API\Request\Financial\Alternatives
 *
 * @method Sofort setCustomerBankId($value) Set the bank id of the bank where the customer resides
 * @method Sofort setBankAccountNumber($value) Set the Bank identification number of the customer
 */
class Sofort extends \Genesis\API\Request\Base\Financial
{
    use AsyncAttributes, PaymentAttributes, AddressInfoAttributes;

    /**
     * The bank id of the bank where the customer resides
     *
     * @var string
     */
    protected $customer_bank_id;
    /**
     * Bank identification number of the customer
     *
     * @var string
     */
    protected $bank_account_number;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::SOFORT;
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
            'billing_country' => ['AT', 'BE', 'DE', 'ES', 'FR', 'GB', 'IT', 'NL'],
            'currency'        => \Genesis\Utils\Currency::getList()
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
            'return_success_url'  => $this->return_success_url,
            'return_failure_url'  => $this->return_failure_url,
            'amount'              => $this->transformAmount($this->amount, $this->currency),
            'currency'            => $this->currency,
            'customer_email'      => $this->customer_email,
            'customer_phone'      => $this->customer_phone,
            'customer_bank_id'    => $this->customer_bank_id,
            'bank_account_number' => $this->bank_account_number,
            'billing_address'     => $this->getBillingAddressParamsStructure(),
            'shipping_address'    => $this->getShippingAddressParamsStructure()
        ];
    }
}
