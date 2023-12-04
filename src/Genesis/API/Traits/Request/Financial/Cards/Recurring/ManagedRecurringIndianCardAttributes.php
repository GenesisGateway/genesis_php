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

use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\PaymentTypes;
use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\AmountTypes;
use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\Frequencies;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common;

/**
 * Trait ManagedRecurringIndianCardAttributes
 *
 * Recurring transactions with cards issued in India are subject to special rules. Prior to requesting the recurring
 * transaction, the merchant should register the recurring agreement as per the Reserve bank of India (RBI) regulations.
 *
 * @package Genesis\API\Traits\Request\Financial\Cards\Recurring
 *
 * @method string|null getManagedRecurringPaymentType()
 * @method string|null getManagedRecurringAmountType()
 * @method string|null getManagedRecurringFrequency()
 * @method mixed       getManagedRecurringRegistrationReferenceNumber()
 * @method mixed       getManagedRecurringMaxAmount()
 * @method bool        getManagedRecurringValidated()
 *
 * @method $this       setManagedRecurringRegistrationReferenceNumber($value)
 */
trait ManagedRecurringIndianCardAttributes
{
    /**
     * Type of the current recurring transaction.
     *
     * @var string|null $managed_recurring_payment_type Values: initial, subsequent, modification, cancellation
     */
    protected $managed_recurring_payment_type;

    /**
     * Type of the amount.
     *
     * @var string|null $managed_recurring_amount_type Values: fixed, max
     */
    protected $managed_recurring_amount_type;

    /**
     * Frequency of the subsequent transactions.
     *
     * @var string|null $managed_recurring_frequency    Values: daily, twice_weekly, weekly, ten_days, fortnightly,
     *                                                          monthly, every_two_months, trimester, quarterly,
     *                                                          twice_yearly, annually, unscheduled
     */
    protected $managed_recurring_frequency;

    /**
     * Reference number as per the agreement.
     *
     * @var mixed $managed_recurring_registration_reference_number
     */
    protected $managed_recurring_registration_reference_number;

    /**
     * Maximum amount as per the agreement.
     *
     * @var mixed $managed_recurring_max_amount
     */
    protected $managed_recurring_max_amount;

    /**
     * Indicates if the current transaction is valid as per the registered agreement.
     *
     * @var mixed $managed_recurring_validated
     */
    protected $managed_recurring_validated;

    /**
     * Type of the current recurring transaction.
     *
     * @param string|null $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setManagedRecurringPaymentType($value)
    {
        if (empty($value)) {
            $this->managed_recurring_payment_type = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'managed_recurring_payment_type',
            PaymentTypes::getAll(),
            $value,
            'Invalid value given for Payment Type.'
        );
    }

    /**
     * Type of the amount
     *
     * @param string|null $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setManagedRecurringAmountType($value)
    {
        if (empty($value)) {
            $this->managed_recurring_amount_type = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'managed_recurring_amount_type',
            AmountTypes::getAll(),
            $value,
            'Invalid value given for Amount Type.'
        );
    }

    /**
     * Frequency of the subsequent transactions.
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setManagedRecurringFrequency($value)
    {
        if (empty($value)) {
            $this->managed_recurring_frequency = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'managed_recurring_frequency',
            Frequencies::getAll(),
            $value,
            'Invalid value given for Frequency.'
        );
    }

    /**
     * Indicates if the current transaction is valid as per the registered agreement.
     *
     * @param $value
     * @return $this
     */
    public function setManagedRecurringValidated($value)
    {
        $this->managed_recurring_validated = Common::toBoolean($value);

        return $this;
    }

    /**
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setManagedRecurringMaxAmount($value)
    {
        return $this->parseAmount('managed_recurring_max_amount', $value);
    }

    /**
     * The managed_recurring attributes structure for Indian Cards without mode parameter
     *
     * @return array
     */
    public function getManagedRecurringIndianCardAttributesStructure()
    {
        return [
            'payment_type'                  => $this->managed_recurring_payment_type,
            'amount_type'                   => $this->managed_recurring_amount_type,
            'frequency'                     => $this->managed_recurring_frequency,
            'registration_reference_number' => $this->managed_recurring_registration_reference_number,
            'max_amount'                    => $this->managed_recurring_max_amount ?
                $this->transformAmount($this->managed_recurring_max_amount, $this->currency) : null,
            'validated'                     => $this->managed_recurring_validated !== null ?
                var_export($this->managed_recurring_validated, true) : null
        ];
    }
}
