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

namespace Genesis\API\Request\Financial\Mobile;

use Genesis\API\Constants\Transaction\Parameters\RussianMobileOperators;
use Genesis\API\Constants\Transaction\Types;
use Genesis\API\Request\Base\Financial;
use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\Financial\PendingPaymentAttributes;
use Genesis\API\Traits\RestrictedSetter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class RussianMobileSale
 *
 * Russian Mobile Sale Request
 *
 * @package Genesis\API\Request\Financial\Mobile\RussianMobileSale
 *
 * @method string getTarget()
 * @method string getOperator()
 */
class RussianMobileSale extends Financial
{
    use AsyncAttributes, PaymentAttributes, AddressInfoAttributes, PendingPaymentAttributes, RestrictedSetter;

    const USAGE_MIN_LENGTH = 1;
    const USAGE_MAX_LENGTH = 5;

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
    public function setUsage($value)
    {
        if ($value === null) {
            $this->usage = null;

            return $this;
        }

        return $this->setLimitedString(
            'usage',
            $value,
            self::USAGE_MIN_LENGTH,
            self::USAGE_MAX_LENGTH
        );
    }

    /**
     * @return string
     */
    protected function getTransactionType()
    {
        return Types::RUSSIAN_MOBILE_SALE;
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
            'usage',
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

        $requiredFieldValues = [
            'operator'        => RussianMobileOperators::getAll(),
            'currency'        => ['RUB'],
            'billing_country' => ['RU'],
        ];

        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }

    /**
     * Return additional request attributes
     *
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'return_success_url' => $this->return_success_url,
            'return_failure_url' => $this->return_failure_url,
            'return_pending_url' => $this->getReturnPendingUrl(),
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
}
