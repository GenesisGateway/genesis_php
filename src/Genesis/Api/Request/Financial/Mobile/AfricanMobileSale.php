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
 * @copyright   Copyright (C) 2015-2025 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Request\Financial\Mobile;

use Genesis\Api\Constants\Transaction\Parameters\AfricanMobileOperators;
use Genesis\Api\Constants\Transaction\Types;
use Genesis\Api\Request\Base\Financial;
use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\Financial\AsyncAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class AfricanMobileSale
 *
 * African Mobile Sale Request
 *
 * @package Genesis\Api\Request\Financial\Mobile\AfricanMobileSale
 *
 * @method string getOperator()
 * @method string getTarget()
 */
class AfricanMobileSale extends Financial
{
    use AddressInfoAttributes;
    use AsyncAttributes;
    use PaymentAttributes;

    const OPERATOR_MIN_LENGTH = 1;
    const OPERATOR_MAX_LENGTH = 20;

    const TARGET_MIN_LENGTH   = 1;
    const TARGET_MAX_LENGTH   = 20;

    /**
     * @var string
     */
    protected $operator;

    /**
     * @var string
     */
    protected $target;

    /**
     * @param $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setOperator($value)
    {
        if ($value === null) {
            $this->operator = null;

            return $this;
        }

        return $this->setLimitedString(
            'operator',
            $value,
            self::OPERATOR_MIN_LENGTH,
            self::OPERATOR_MAX_LENGTH
        );
    }

    /**
     * @param $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setTarget($value)
    {
        if ($value === null) {
            $this->target = null;

            return $this;
        }

        return $this->setLimitedString(
            'target',
            $value,
            self::TARGET_MIN_LENGTH,
            self::TARGET_MAX_LENGTH
        );
    }

    /**
     * @return string
     */
    protected function getTransactionType()
    {
        return Types::AFRICAN_MOBILE_SALE;
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
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'operator',
            'target',
            'customer_phone',
            'billing_country'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues  = [
            'operator'        => $this->getAllowedOperators(),
            'currency'        => $this->getAllowedCurrencies(),
            'billing_country' => $this->getAllowedCountries()
        ];

        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);

        $this->requiredFieldValuesConditional = CommonUtils::createArrayObject(
            $this->buildRequiredFieldValuesConditional()
        );
    }

    /**
     * Return additional request attributes
     *
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'usage'              => $this->usage,
            'return_success_url' => $this->return_success_url,
            'return_failure_url' => $this->return_failure_url,
            'amount'             => $this->transformAmount($this->amount, $this->currency),
            'currency'           => $this->currency,
            'operator'           => $this->operator,
            'target'             => $this->target,
            'customer_email'     => $this->customer_email,
            'customer_phone'     => $this->customer_phone,
            'billing_address'    => $this->getBillingAddressParamsStructure(),
            'shipping_address'   => $this->getShippingAddressParamsStructure()
        ];
    }

    /**
     * @return array
     */
    private function buildRequiredFieldValuesConditional()
    {
        return [
            'billing_country' => [
                'GH' => [
                    [
                        'currency' => ['GHS'],
                        'operator' => [AfricanMobileOperators::VODACOM]
                    ]
                ],
                'KE' => [
                    [
                        'currency' => ['KES'],
                        'operator' => [AfricanMobileOperators::SAFARICOM]
                    ]
                ],
                'UG' => [
                    [
                        'currency' => ['UGX'],
                        'operator' => [AfricanMobileOperators::MTN, AfricanMobileOperators::AIRTEL]
                    ]
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    private function getAllowedCountries()
    {
        return [
            'GH', 'KE', 'UG'
        ];
    }

    /**
     * @return array
     */
    private function getAllowedCurrencies()
    {
        return [
            'GHS', 'KES', 'UGX'
        ];
    }

    /**
     * @return array
     */
    private function getAllowedOperators()
    {
        return [
            AfricanMobileOperators::AIRTEL,
            AfricanMobileOperators::MTN,
            AfricanMobileOperators::SAFARICOM,
            AfricanMobileOperators::VODACOM
        ];
    }
}
