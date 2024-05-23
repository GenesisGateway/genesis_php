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
 * Trait TravelAgenciesAttributes
 * @package Genesis\Api\Traits\Request\Financial\Business
 *
 * @method $this setBusinessCarrierCode($value) Set code of the carrier
 * @method $this setBusinessFlightNumber($value) Set flight number
 * @method $this setBusinessTicketNumber($value) Set ticket number
 * @method $this setBusinessOriginCity($value) Set origin city
 * @method $this setBusinessDestinationCity($value) Set destination city
 * @method $this setBusinessTravelAgency($value) Set name of the travel agency
 * @method $this setBusinessContractorName($value) Set name of the contractor
 * @method $this setBusinessAtolCertificate($value) Set ATOL(Air Travel Organiser’s Licence) certificate number
 */
trait TravelAgenciesAttributes
{
    /**
     * The date of arrival
     *
     * @var string $business_arrival_date
     */
    protected $business_arrival_date;

    /**
     * The date of departure
     *
     * @var string $business_departure_date
     */
    protected $business_departure_date;

    /**
     * The code of the carrier
     *
     * @var string $business_carrier_code
     */
    protected $business_carrier_code;

    /**
     * The number of the flight
     *
     * @var string $business_flight_number
     */
    protected $business_flight_number;

    /**
     * The number of the ticket
     *
     * @var string $business_ticket_number
     */
    protected $business_ticket_number;

    /**
     * The origin city
     *
     * @var string $business_origin_city
     */
    protected $business_origin_city;

    /**
     * The destination city
     *
     * @var string $business_destination_city
     */
    protected $business_destination_city;

    /**
     * The name of the travel agency
     * @var string $business_travel_agency
     */
    protected $business_travel_agency;

    /**
     * The name of the contractor
     *
     * @var string $business_contractor_name
     */
    protected $business_contractor_name;

    /**
     * ATOL certificate number
     *
     * @var string $business_atol_certificate
     */
    protected $business_atol_certificate ;

    /**
     * Pick-up date
     *
     * @var string $business_pick_up_date
     */
    protected $business_pick_up_date;

    /**
     * Return date
     * @var string $business_return_date;
     */
    protected $business_return_date;

    /**
     *  Set date of arrival
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessArrivalDate($value)
    {
        if ($value === null) {
            $this->business_arrival_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_arrival_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_arrival_date.'
        );
    }

    /**
     *  Set date of departure
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessDepartureDate($value)
    {
        if ($value === null) {
            $this->business_departure_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_departure_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_departure_date.'
        );
    }

    /**
     *  Set pick up date
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessPickUpDate($value)
    {
        if ($value === null) {
            $this->business_pick_up_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_pick_up_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_pick_up_date.'
        );
    }

    /**
     *  Set date of return
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessReturnDate($value)
    {
        if ($value === null) {
            $this->business_return_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_return_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_return_date.'
        );
    }

    /**
     * @return string
     */
    public function getBusinessArrivalDate()
    {
        return empty($this->business_arrival_date) ?
            null : $this->business_arrival_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return string
     */
    public function getBusinessDepartureDate()
    {
        return empty($this->business_departure_date) ?
            null : $this->business_departure_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return string
     */
    public function getBusinessPickUpDate()
    {
        return empty($this->business_pick_up_date) ?
            null : $this->business_pick_up_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return string
     */
    public function getBusinessReturnDate()
    {
        return empty($this->business_return_date) ?
            null : $this->business_return_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return array
     */
    public function getTravelAgenciesAttributesStructure()
    {
        return  [
            'arrival_date'     => $this->getBusinessArrivalDate(),
            'departure_date'   => $this->getBusinessDepartureDate(),
            'carrier_code'     => $this->business_carrier_code,
            'flight_number'    => $this->business_flight_number,
            'ticket_number'    => $this->business_ticket_number,
            'origin_city'      => $this->business_origin_city,
            'destination_city' => $this->business_destination_city,
            'travel_agency'    => $this->business_travel_agency,
            'contractor_name'  => $this->business_contractor_name,
            'atol_certificate' => $this->business_atol_certificate,
            'pick_up_date'     => $this->getBusinessPickUpDate(),
            'return_date'      => $this->getBusinessReturnDate()
        ];
    }
}
