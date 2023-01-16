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

namespace Genesis\API\Request\Financial\Alternatives\Trustly;

use Genesis\API\Request\Base\Financial;
use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\BirthDateAttributes;
use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class Withdrawal
 *
 * Trustly Withdrawal Alternative payment method
 *
 * @package Genesis\API\Request\Financial\Alternatives\Trustly
 */
class Withdrawal extends Financial
{
    use AsyncAttributes, PaymentAttributes, AddressInfoAttributes, RestrictedSetter, BirthDateAttributes;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::TRUSTLY_WITHDRAWAL;
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        parent::setRequiredFields();

        $requiredFields = [
            'transaction_id',
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url',
            'customer_email',
            'birth_date',
            'billing_country'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'billing_country' => [
                'AT', 'BG', 'BE', 'HR', 'CZ', 'CY', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR', 'HU', 'IT', 'IE', 'LT', 'LV',
                'LU', 'MT', 'NO',  'NL', 'PT', 'PL', 'RO', 'SK', 'SI', 'SE', 'ES', 'GB'
            ],
            'currency'        => \Genesis\Utils\Currency::getList()
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
    }

    protected function getPaymentTransactionStructure()
    {
        return array_merge(
            $this->getPaymentAttributesStructure(),
            [
                'return_success_url'        => $this->return_success_url,
                'return_failure_url'        => $this->return_failure_url,
                'amount'                    => $this->transformAmount($this->amount, $this->currency),
                'currency'                  => $this->currency,
                'customer_email'            => $this->customer_email,
                'customer_phone'            => $this->customer_phone,
                'birth_date'                => $this->getBirthDate(),
                'billing_address'           => $this->getBillingAddressParamsStructure(),
                'shipping_address'          => $this->getShippingAddressParamsStructure()
            ]
        );
    }
}
