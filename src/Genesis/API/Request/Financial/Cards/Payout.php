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

namespace Genesis\API\Request\Financial\Cards;

use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\CreditCardAttributes;
use Genesis\API\Traits\Request\AddressInfoAttributes;

/**
 * Class Payout
 *
 * Payout Request
 *
 * @package Genesis\API\Request\Financial\Cards
 */
class Payout extends \Genesis\API\Request\Base\Financial
{
    use PaymentAttributes, CreditCardAttributes, AddressInfoAttributes;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::PAYOUT;
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
            'card_holder',
            'card_number',
            'expiration_month',
            'expiration_year'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues = array_merge(
            [
                'currency' => \Genesis\Utils\Currency::getList()
            ],
            $this->getCCFieldValueFormatValidators()
        );

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'amount'           => $this->transformAmount($this->amount, $this->currency),
            'currency'         => $this->currency,
            'card_holder'      => $this->card_holder,
            'card_number'      => $this->card_number,
            'cvv'              => $this->cvv,
            'expiration_month' => $this->expiration_month,
            'expiration_year'  => $this->expiration_year,
            'customer_email'   => $this->customer_email,
            'customer_phone'   => $this->customer_phone,
            'birth_date'       => $this->birth_date,
            'billing_address'  => $this->getBillingAddressParamsStructure(),
            'shipping_address' => $this->getShippingAddressParamsStructure()
        ];
    }
}
