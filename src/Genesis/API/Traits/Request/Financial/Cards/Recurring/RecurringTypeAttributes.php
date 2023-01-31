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

namespace Genesis\API\Traits\Request\Financial\Cards\Recurring;

use Genesis\API\Constants\Transaction\Parameters\Recurring\Types;

/**
 * trait RecurringTypeAttributes
 *
 * Specifies the recurring type of transaction. Act like obsolete Init Recurring Sale/3D transactions.
 *
 * @package Genesis\API\Traits\Request\Financial\Cards\Recurring
 *
 * @method string getRecurringType()       Specifies the recurring type of transaction
 * @method $this  setRecurringType($value) Specifies the recurring type of transaction
 */
trait RecurringTypeAttributes
{
    /**
     * @var string $recurring_type Specifies the recurring type of transaction
     */
    protected $recurring_type;

    /**
     * Returns Field Values Conditional validation applicable for Initial Recurring Type
     *
     * @return array[]
     */
    protected function requiredRecurringInitialTypesFieldValuesConditional()
    {
        return [
            'recurring_type' => [
                $this->recurring_type => [
                    ['recurring_type' => Types::getInitialTypes()]
                ]
            ]
        ];
    }

    /**
     * Returns Field Values Conditional validation applicable for Sale Transaction Type Recurring Type
     *
     * @return array[]
     */
    protected function requiredRecurringAllTypesFieldValuesConditional()
    {
        return [
            'recurring_type' => [
                $this->recurring_type => [
                    ['recurring_type' => array_merge(
                        Types::getInitialTypes(),
                        Types::getSubsequentTypes()
                    )]
                ]
            ]
        ];
    }

    /**
     * Returns Conditional Fields validation applicable for Subsequent Recurring Type
     *
     * @return array[]
     */
    protected function requiredRecurringSubsequentTypeFieldConditional()
    {
        return [
            'recurring_type' => [
                Types::SUBSEQUENT => [
                    'reference_id'
                ]
            ]
        ];
    }

    /**
     * Returns Conditional Fields validation applicable for Managed Recurring Type. Managed Recurring attributes are
     * required in this case.
     *
     * @return array[]
     */
    protected function requiredRecurringManagedTypeFieldConditional()
    {
        return [
            'recurring_type' => [
                Types::MANAGED => [
                    'managed_recurring_mode'
                ]
            ]
        ];
    }
}
