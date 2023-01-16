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

namespace Genesis\API\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait Recurring
 * @package Genesis\API\Traits\Request\Financial\Threeds\V2
 *
 * @method int getThreedsV2RecurringFrequency() Indicates the minimum number of days between subsequent transactions
 */
trait Recurring
{
    /**
     * A future date indicating the end date for any further subsequent transactions
     *
     * @var \DateTime $threeds_v2_recurring_expiration_date
     */
    protected $threeds_v2_recurring_expiration_date;

    /**
     * Indicates the minimum number of days between subsequent transactions
     *
     * @var int $threeds_v2_recurring_frequency
     */
    protected $threeds_v2_recurring_frequency;

    /**
     * A future date indicating the end date for any further subsequent transactions
     *
     * @return string|null
     */
    public function getThreedsV2RecurringExpirationDate()
    {
        return (empty($this->threeds_v2_recurring_expiration_date)) ? null :
            $this->threeds_v2_recurring_expiration_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * A future date indicating the end date for any further subsequent transactions
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setThreedsV2RecurringExpirationDate($value)
    {
        if (is_null($value)) {
            $this->threeds_v2_recurring_expiration_date = null;

            return $this;
        }

        return $this->parseDate(
            'threeds_v2_recurring_expiration_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid threeds_v2_recurring_expiration_date.'
        );
    }

    /**
     * Indicates the minimum number of days between subsequent transactions
     *
     * @param int $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setThreedsV2RecurringFrequency($value)
    {
        $this->threeds_v2_recurring_frequency = (int) $value;

        if ($value < 1 || $value > 9999) {
            throw new InvalidArgument(
                'Invalid value for threeds_v2_recurring_frequency. Values between 1 and 9999 are accepted'
            );
        }

        return $this;
    }

    /**
     * Get the Recurring Attributes
     *
     * @return array
     */
    protected function getRecurringAttributes()
    {
        return [
            'expiration_date' => $this->getThreedsV2RecurringExpirationDate(),
            'frequency'       => $this->getThreedsV2RecurringFrequency()
        ];
    }
}
