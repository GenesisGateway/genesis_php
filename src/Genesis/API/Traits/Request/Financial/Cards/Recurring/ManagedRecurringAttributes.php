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

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\Intervals;
use Genesis\API\Constants\Transaction\Parameters\ManagedRecurring\Modes;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait ManagedRecurringAttributes
 *
 * Managed Recurring provides the option to automatically schedule recurring transactions for
 * a specific day and time. Managed Recurring is available after additional configuration.
 *
 * @package Genesis\API\Traits\Request\Financial\Cards\Recurring
 *
 * @method string  getManagedRecurringMode()
 * @method string  getManagedRecurringInterval()
 * @method integer getManagedRecurringTimeOfDay()
 * @method integer getManagedRecurringPeriod()
 * @method integer getManagedRecurringAmount()
 * @method integer getManagedRecurringMaxCount()
 *
 * @method $this   setManagedRecurringTimeOfDay($value)
 * @method $this   setManagedRecurringPeriod($value)
 */
trait ManagedRecurringAttributes
{
    use ManagedRecurringIndianCardAttributes;

    /**
     * Indicates that the gateway will automatically manage or not the subsequent recurring transactions.
     *
     * @var string $managed_recurring_mode              Fill in with automatic or manual
     */
    protected $managed_recurring_mode;

    /**
     * The interval type for the period. The default value is days.
     *
     * @var string $managed_recurring_interval          Allowed: days or months
     */
    protected $managed_recurring_interval;

    /**
     * @var \DateTime $managed_recurring_first_date Specifies the date of the first recurring event in the future,
     * default value is date of creation + period. The format is ISO 8601 date format YYYY-MM-DD.
     */
    protected $managed_recurring_first_date;

    /**
     * @var integer $managed_recurring_time_of_day  Specifies the UTC hour in the day for the execution of the
     * recurring transaction, default value 0.
     */
    protected $managed_recurring_time_of_day;

    /**
     * @var integer $managed_recurring_period       Rebill period in days(30) or months(12).
     */
    protected $managed_recurring_period;

    /**
     *
     * @var integer $managed_recurring_amount       Amount for the recurring transactions.
     */
    protected $managed_recurring_amount;

    /**
     * @var integer $managed_recurring_max_count    Maximum number of times a recurring will occur.
     * Omit this parameter for unlimited recurring.
     */
    protected $managed_recurring_max_count;

    /**
     * Indicates that the gateway will automatically manage or not the subsequent recurring transactions.
     *
     * @param string|null $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setManagedRecurringMode($value)
    {
        if (empty($value)) {
            $this->managed_recurring_mode = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'managed_recurring_mode',
            Modes::getAll(),
            $value,
            'Invalid value given for Mode.'
        );
    }

    /**
     * Specifies the date of the first recurring event in the future, default value is date of creation + period.
     * The format is ISO 8601 date format YYYY-MM-DD.
     * @return string|null
     */
    public function getManagedRecurringFirstDate()
    {
        return (empty($this->managed_recurring_first_date)) ? null :
            $this->managed_recurring_first_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setManagedRecurringFirstDate($value)
    {
        if (empty($value)) {
            $this->managed_recurring_first_date = null;

            return $this;
        }

        return $this->parseDate(
            'managed_recurring_first_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid value given for First Date.'
        );
    }

    /**
     * The interval type for the period: days or months. The default value is days
     *
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setManagedRecurringInterval($value)
    {
        if (empty($value)) {
            $this->managed_recurring_interval = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'managed_recurring_interval',
            Intervals::getAll(),
            $value,
            'Invalid value given for Interval.'
        );
    }

    /**
     * Maximum transactions count as per the agreement.
     *
     * @param $value
     * @return $this
     */
    public function setManagedRecurringMaxCount($value)
    {
        $this->managed_recurring_max_count = (int) $value;

        return $this;
    }

    /**
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setManagedRecurringAmount($value)
    {
        return $this->parseAmount('managed_recurring_amount', $value);
    }

    /**
     * Describes requirement of managed_recurring_period
     * @return array
     */
    protected function requiredManagedRecurringFieldsConditional()
    {
        return [
            'managed_recurring_period'      => ['managed_recurring_mode'],
            'managed_recurring_interval'    => ['managed_recurring_mode'],
            'managed_recurring_first_date'  => ['managed_recurring_mode'],
            'managed_recurring_time_of_day' => ['managed_recurring_mode'],
            'managed_recurring_amount'      => ['managed_recurring_mode'],
            'managed_recurring_max_count'   => ['managed_recurring_mode'],

            // Indian Cards Requirements, managed_recurring_mode is required
            'managed_recurring_payment_type'                  => ['managed_recurring_mode'],
            'managed_recurring_amount_type'                   => ['managed_recurring_mode'],
            'managed_recurring_frequency'                     => ['managed_recurring_mode'],
            'managed_recurring_registration_reference_number' => ['managed_recurring_mode'],
            'managed_recurring_max_amount'                    => ['managed_recurring_mode'],
            'managed_recurring_validated'                     => ['managed_recurring_mode']
        ];
    }

    /**
     * The managed_recurring parameters structure
     * @return array
     */
    protected function getManagedRecurringAttributesStructure()
    {
        return array_merge(
            [
                'mode'        => $this->managed_recurring_mode,
                'interval'    => $this->managed_recurring_interval,
                'first_date'  => $this->getManagedRecurringFirstDate(),
                'time_of_day' => $this->managed_recurring_time_of_day,
                'period'      => $this->managed_recurring_period,
                'amount'      => $this->managed_recurring_amount ?
                $this->transformAmount($this->managed_recurring_amount, $this->currency) : null,
                'max_count'   => $this->managed_recurring_max_count
            ],
            $this->getManagedRecurringIndianCardAttributesStructure()
        );
    }
}
