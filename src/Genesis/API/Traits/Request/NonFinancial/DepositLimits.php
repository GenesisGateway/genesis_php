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

namespace Genesis\API\Traits\Request\NonFinancial;

use Genesis\API\Request\Base\NonFinancial\KYC\BaseRequest;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait DepositLimits
 * @package Genesis\API\Traits\Request\NonFinancial
 */
trait DepositLimits
{
    /**
     * @var string
     */
    protected $payment_method;

    /**
     * @var string
     */
    protected $minimum;

    /**
     * @var string
     */
    protected $daily_maximum;

    /**
     * @var string
     */
    protected $weekly_maximum;

    /**
     * @var string
     */
    protected $monthly_maximum;

    /**
     * CC; EC; EW - CreditCard; Echeck; EWallet
     *
     * @param $method
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setPaymentMethod($method)
    {
        return $this->allowedOptionsSetter(
            'payment_method',
            [
                BaseRequest::PAYMENT_METHOD_CREDIT_CARD,
                BaseRequest::PAYMENT_METHOD_ECHECK,
                BaseRequest::PAYMENT_METHOD_EWALLET
            ],
            $method,
            'Invalid payment method provided.'
        );
    }

    public function getDepositLimitsStructure()
    {
        return [
            'payment_method'  => $this->payment_method,
            'minimum'         => $this->minimum,
            'daily_maximum'   => $this->daily_maximum,
            'weekly_maximum'  => $this->weekly_maximum,
            'monthly_maximum' => $this->monthly_maximum
        ];
    }
}
