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

namespace Genesis\API\Traits\Request\Financial\OnlineBankingPayments;

use Genesis\API\Validators\Request\RegexValidator;

/**
 * Trait VirtualPaymentAddressAttributes
 * @package Genesis\API\Traits\Request\Financial\OnlineBankingPayments
 *
 * @method $this getVirtualPaymentAddress() Get value
 */
trait VirtualPaymentAddressAttributes
{
    /**
     * Virtual Payment Address (VPA) of the customer, format: someone@bank
     *
     * @var $virtual_payment_address
     */
    protected $virtual_payment_address;

    /**
     * Virtual Payment Address (VPA) of the customer, format: someone@bank
     *
     * @param string $value
     *
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setVirtualPaymentAddress($value)
    {
        $this->virtual_payment_address = $value;

        if (empty($value)) {
            return $this;
        }

        $this->getVirtualPaymentAddressValidator()->run(
            $this,
            'virtual_payment_address'
        );

        return $this;
    }

    /**
     * Virtual Payment Address validation rules
     *
     * @return RegexValidator
     */
    protected function getVirtualPaymentAddressValidator()
    {
        return new RegexValidator(
            RegexValidator::PATTERN_VIRTUAL_PAYMENT_ADDRESS,
            'Please check input data for errors. virtual_payment_address has invalid format. ' .
            'Correct format: someone@bank'
        );
    }
}
