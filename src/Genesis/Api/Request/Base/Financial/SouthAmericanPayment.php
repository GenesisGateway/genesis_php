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

namespace Genesis\Api\Request\Base\Financial;

use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\Financial\AsyncAttributes;
use Genesis\Api\Traits\Request\Financial\BirthDateAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Api\Traits\Request\Financial\PproAttributes;

/**
 * Class SouthAmericanPayment
 *
 * Base Class for South American Methods
 *
 * @package Genesis\Api\Request\Base\Financial
 */
abstract class SouthAmericanPayment extends \Genesis\Api\Request\Base\Financial
{
    use AddressInfoAttributes;
    use AsyncAttributes;
    use BirthDateAttributes;
    use PaymentAttributes;
    use PproAttributes;

    /**
     * @return array
     */
    abstract public function getAllowedBillingCountries();

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_id',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'consumer_reference',
            'national_id',
            'customer_email',
            'billing_country'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $allowedBillingCountries = $this->getAllowedBillingCountries();
        if (!empty($allowedBillingCountries)) {
            $requiredFieldValues = [
                'billing_country' => $allowedBillingCountries
            ];

            $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
        }
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'usage'              => $this->usage,
            'remote_ip'          => $this->remote_ip,
            'return_success_url' => $this->return_success_url,
            'return_failure_url' => $this->return_failure_url,
            'amount'             => $this->transformAmount($this->amount, $this->currency),
            'currency'           => $this->currency,
            'consumer_reference' => $this->consumer_reference,
            'national_id'        => $this->national_id,
            'birth_date'         => $this->getBirthDate(),
            'customer_email'     => $this->customer_email,
            'billing_address'    => $this->getBillingAddressParamsStructure(),
            'shipping_address'   => $this->getShippingAddressParamsStructure()
        ];
    }
}
