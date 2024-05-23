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
 * Trait HotelsAndRealEstateRentalsAttributes
 * @package Genesis\Api\Traits\Request\Financial\Business
 *
 * @method $this setBusinessTravelAgencyName($value) Set travel agency name
 */
trait HotelsAndRealEstateRentalsAttributes
{
    /**
     * The data when the customer check-in
     *
     * @var string $business_check_in_date
     */
    protected $business_check_in_date;

    /**
     * The data when the customer check-out
     *
     * @var string $business_check_out_date
     */
    protected $business_check_out_date;

    /**
     * Travel agency name
     *
     * @var string $business_travel_agency_name
     */
    protected $business_travel_agency_name;

    /**
     *  Set date when the customer check-in
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessCheckInDate($value)
    {
        if ($value === null) {
            $this->business_check_in_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_check_in_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_check_in_date.'
        );
    }

    /**
     *  Set data when the customer check-out
     *
     * @param  string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessCheckOutDate($value)
    {
        if ($value === null) {
            $this->business_check_out_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_check_out_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_check_out_date.'
        );
    }

    /**
     * @return string
     */
    public function getBusinessCheckInDate()
    {
        return empty($this->business_check_in_date) ?
            null : $this->business_check_in_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return string
     */
    public function getBusinessCheckOutDate()
    {
        return empty($this->business_check_out_date) ?
            null : $this->business_check_out_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return array
     */
    public function getHotelsAndRealEstateRentalsAttributesStructure()
    {
        return  [
            'check_in_date'      => $this->getBusinessCheckInDate(),
            'check_out_date'     => $this->getBusinessCheckOutDate(),
            'travel_agency_name' => $this->business_travel_agency_name
            ];
    }
}
