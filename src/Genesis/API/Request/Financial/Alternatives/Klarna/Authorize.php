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

namespace Genesis\API\Request\Financial\Alternatives\Klarna;

use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\AddressInfoAttributes;

/**
 * Class Authorize
 *
 * Alternative payment method
 *
 * @package Genesis\API\Request\Financial\Alternatives\Klarna
 *
 * @method $this setPaymentMethodCategory($value) Set payment method category
 */
class Authorize extends \Genesis\API\Request\Base\Financial\Alternative\Klarna
{
    use AsyncAttributes, AddressInfoAttributes;

    const PAYMENT_METHOD_CATEGORY_PAY_LATER      = 'pay_later';
    const PAYMENT_METHOD_CATEGORY_PAY_OVER_TIME  = 'pay_over_time';
    
    /**
     * Payment Method Category
     *
     * @var string
     */
    protected $payment_method_category;

    /**
     * Customer Gender
     *
     * @var string
     */
    protected $customer_gender;

    /**
     * @return array
     */
    public static function getAllowedCountries()
    {
        return ['AT', 'DK', 'FI', 'DE', 'NL', 'NO', 'SE'];
    }

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::KLARNA_AUTHORIZE;
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
            'payment_method_category',
            'billing_country',
            'shipping_country'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'payment_method_category' => [
                self::PAYMENT_METHOD_CATEGORY_PAY_LATER,
                self::PAYMENT_METHOD_CATEGORY_PAY_OVER_TIME
            ],
            'billing_country'         => static::getAllowedCountries(),
            'shipping_country'        => static::getAllowedCountries()
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return array_merge(
            parent::getPaymentTransactionStructure(),
            [
                'customer_email'          => $this->customer_email,
                'customer_phone'          => $this->customer_phone,
                'payment_method_category' => $this->payment_method_category,
                'customer_gender'         => $this->customer_gender,
                'billing_address'         => $this->getBillingAddressParamsStructure(),
                'shipping_address'        => $this->getShippingAddressParamsStructure(),
                'return_success_url'      => $this->return_success_url,
                'return_failure_url'      => $this->return_failure_url
            ]
        );
    }
}
