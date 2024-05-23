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

namespace Genesis\Api\Traits\Request\Financial\Business;

use Genesis\Api\Constants\DateTimeFormat;

/**
 * Trait CruiseLinesAttributes
 * @package Genesis\Api\Traits\Request\Financial\Business
 */
trait CruiseLinesAttributes
{
    /**
     * The date when cruise begins
     *
     * @var string $business_cruise_start_date
     */
    protected $business_cruise_start_date;

    /**
     * The date when cruise ends
     *
     * @var string $business_cruise_end_date
     */
    protected $business_cruise_end_date;

    /**
     *  Set date when cruise begins
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessCruiseStartDate($value)
    {
        if ($value === null) {
            $this->business_cruise_start_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_cruise_start_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_cruise_start_date.'
        );
    }

    /**
     *  Set date when cruise ends
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessCruiseEndDate($value)
    {
        if ($value === null) {
            $this->business_cruise_end_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_cruise_end_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_cruise_end_date.'
        );
    }

    /**
     * @return string
     */
    public function getBusinessCruiseStartDate()
    {
        return empty($this->business_cruise_start_date) ?
            null : $this->business_cruise_start_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return string
     */
    public function getBusinessCruiseEndDate()
    {
        return empty($this->business_cruise_end_date) ?
            null : $this->business_cruise_end_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return array
     */
    public function getCruiseLinesAttributesStructure()
    {
        return [
            'cruise_start_date' => $this->getBusinessCruiseStartDate(),
            'cruise_end_date'   => $this->getBusinessCruiseEndDate()
        ];
    }
}
