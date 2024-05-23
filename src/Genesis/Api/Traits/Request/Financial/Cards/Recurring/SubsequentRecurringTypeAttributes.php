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

namespace Genesis\Api\Traits\Request\Financial\Cards\Recurring;

use Genesis\Api\Constants\Transaction\Parameters\Recurring\Types;
use Genesis\Utils\Common as CommonUtils;

/**
 * trait SubsequentRecurringTypeAttributes
 *
 * @package Genesis\Api\Traits\Request\Financial\Cards\Recurring
 */
trait SubsequentRecurringTypeAttributes
{
    /**
     * Apply transformation: Convert to Minor currency unit
     * When recurring type is Subsequent and there is no currency
     * the amount will not be modified
     *
     * @param string $amount
     * @param string $currency
     *
     * @return string
     */
    protected function transformAmount($amount = '', $currency = '')
    {
        if ($this->recurring_type == Types::SUBSEQUENT && empty($currency)) {
            return $amount;
        }

        return parent::transformAmount($amount, $currency);
    }

    /**
     * Extend the Request Validations for Subsequent recurring type
     *
     * @return void
     * @throws \Genesis\Exceptions\ErrorParameter
     * @throws \Genesis\Exceptions\InvalidArgument
     * @throws \Genesis\Exceptions\InvalidClassMethod
     */
    protected function checkRequirementsSubsequent()
    {
        $requiredFields = [
            'transaction_id',
            'amount'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        unset($this->requiredFieldsOR);

        unset($this->requiredFieldValues);

        $requiredFieldValuesConditional = $this->requiredRecurringAllTypesFieldValuesConditional();

        $this->requiredFieldValuesConditional = CommonUtils::createArrayObject(
            $requiredFieldValuesConditional
        );

        $this->validate();
    }
}
