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
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\NonFinancial;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Validators\Request\RegexValidator;

/**
 * Trait DateTimeFromToAttributes
 *
 * Reusable datetime-aware "from/to" range filters: startDateFrom/startDateTo and
 * endDateFrom/endDateTo. Each accepts a date (Y-m-d) or datetime (Y-m-d H:i:s) value,
 * reusing the same time-detection/formatting mechanism as DateAttributes.
 *
 * @package Genesis\Api\Traits\Request\NonFinancial
 */
trait DateTimeFromToAttributes
{
    /**
     * Start of the requested start-date range (inclusive, server-side)
     *
     * @var \DateTime
     */
    protected $start_date_from;

    /**
     * End of the requested start-date range (non-inclusive, server-side)
     *
     * @var \DateTime
     */
    protected $start_date_to;

    /**
     * Start of the requested end-date range (inclusive, server-side)
     *
     * @var \DateTime
     */
    protected $end_date_from;

    /**
     * End of the requested end-date range (non-inclusive, server-side)
     *
     * @var \DateTime
     */
    protected $end_date_to;

    /**
     * Optional time in start_date_from
     *
     * @var bool
     */
    private $start_date_from_has_time = false;

    /**
     * Optional time in start_date_to
     *
     * @var bool
     */
    private $start_date_to_has_time = false;

    /**
     * Optional time in end_date_from
     *
     * @var bool
     */
    private $end_date_from_has_time = false;

    /**
     * Optional time in end_date_to
     *
     * @var bool
     */
    private $end_date_to_has_time = false;

    /**
     * Set the start of the start-date range. Inclusive (server-side).
     *
     * @param string $date
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setStartDateFrom($date)
    {
        return $this->parseFromToDate('start_date_from', 'start_date_from_has_time', $date, 'Start date from');
    }

    /**
     * Get the formatted start of the start-date range
     *
     * @return string|null
     */
    public function getStartDateFrom()
    {
        return $this->formatFromToDate('start_date_from', 'start_date_from_has_time');
    }

    /**
     * Set the end of the start-date range. Non-inclusive (server-side); not enforced client-side.
     *
     * @param string $date
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setStartDateTo($date)
    {
        return $this->parseFromToDate('start_date_to', 'start_date_to_has_time', $date, 'Start date to');
    }

    /**
     * Get the formatted end of the start-date range
     *
     * @return string|null
     */
    public function getStartDateTo()
    {
        return $this->formatFromToDate('start_date_to', 'start_date_to_has_time');
    }

    /**
     * Set the start of the end-date range. Inclusive (server-side).
     *
     * @param string $date
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setEndDateFrom($date)
    {
        return $this->parseFromToDate('end_date_from', 'end_date_from_has_time', $date, 'End date from');
    }

    /**
     * Get the formatted start of the end-date range
     *
     * @return string|null
     */
    public function getEndDateFrom()
    {
        return $this->formatFromToDate('end_date_from', 'end_date_from_has_time');
    }

    /**
     * Set the end of the end-date range. Non-inclusive (server-side); not enforced client-side.
     *
     * @param string $date
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setEndDateTo($date)
    {
        return $this->parseFromToDate('end_date_to', 'end_date_to_has_time', $date, 'End date to');
    }

    /**
     * Get the formatted end of the end-date range
     *
     * @return string|null
     */
    public function getEndDateTo()
    {
        return $this->formatFromToDate('end_date_to', 'end_date_to_has_time');
    }

    /**
     * Parse and store a date string, detecting an optional time component.
     *
     * @param string $property
     * @param string $hasTimeProperty
     * @param string $date
     * @param string $label
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    private function parseFromToDate($property, $hasTimeProperty, $date, $label)
    {
        if (empty($date)) {
            $this->{$property} = null;
            $this->{$hasTimeProperty} = false;

            return $this;
        }

        // Recompute on every call so replacing a datetime with a plain date clears a stale time flag.
        $this->{$hasTimeProperty} = preg_match(RegexValidator::PATTERN_TIMESTAMP, $date) === 1;

        return $this->parseDate(
            $property,
            DateTimeFormat::getAll(),
            $date,
            sprintf('Invalid value given for %s.', $label)
        );
    }

    /**
     * Format a stored date, keeping the time component when it was provided.
     *
     * @param string $property
     * @param string $hasTimeProperty
     * @return string|null
     */
    private function formatFromToDate($property, $hasTimeProperty)
    {
        if (empty($this->{$property})) {
            return null;
        }

        $format = $this->{$hasTimeProperty} ?
            DateTimeFormat::YYYY_MM_DD_H_I_S : DateTimeFormat::YYYY_MM_DD_ISO_8601;

        return $this->{$property}->format($format);
    }
}
