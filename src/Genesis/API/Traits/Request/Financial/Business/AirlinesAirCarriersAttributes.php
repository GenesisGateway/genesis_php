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

namespace Genesis\API\Traits\Request\Financial\Business;

use Genesis\API\Constants\DateTimeFormat;

/**
 * Trait AirlinesAirCarriersAttributes
 * @package Genesis\API\Traits\Request\Financial\Business
 *
 * @method $this setBusinessAirlineCode($value) Set the code of Airline
 * @method $this setBusinessAirlineFlightNumber($value) Set the flight number
 * @method $this setBusinessFlightTicketNumber($value) Set the flight ticket number
 * @method $this setBusinessFlightOriginCity($value) Set the origin city of flight
 * @method $this setBusinessFlightDestinationCity($value) Set the destination city of flight
 * @method $this setBusinessAirlineTourOperatorName($value) Set the name of tour operator
 */
trait AirlinesAirCarriersAttributes
{
    /**
     * The date when the flight arrives
     *
     * @var string $business_flight_arrival_date
     */
    protected $business_flight_arrival_date;

    /**
     * The date when the flight departs
     *
     * @var string $business_flight_departure_date
     */
    protected $business_flight_departure_date;

    /**
     * The code of Airline
     *
     * @var string $business_airline_code
     */
    protected $business_airline_code;

    /**
     * The flight number
     *
     * @var string $business_airline_flight_number
     */
    protected $business_airline_flight_number;

    /**
     * The number of the flight ticket
     *
     * @var string $business_flight_ticket_number
     */
    protected $business_flight_ticket_number;

    /**
     * The origin city of the flight
     *
     * @var string $business_flight_origin_city
     */
    protected $business_flight_origin_city;

    /**
     * The destination city of the flight
     *
     * @var string $business_flight_destination_city
     */
    protected $business_flight_destination_city;

    /**
     * The name of tour operator
     *
     * @var string $business_airline_tour_operator_name
     */
    protected $business_airline_tour_operator_name;

    /**
     * Set flight arrival date
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessFlightArrivalDate($value)
    {
        if ($value === null) {
            $this->business_flight_arrival_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_flight_arrival_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_flight_arrival_date.'
        );
    }

    /**
     *  Set flight departure date
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessFlightDepartureDate($value)
    {
        if ($value === null) {
            $this->business_flight_departure_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_flight_departure_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_flight_departure_date.'
        );
    }

    /**
     * @return string
     */
    public function getBusinessFlightArrivalDate()
    {
        return empty($this->business_flight_arrival_date) ?
            null : $this->business_flight_arrival_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return string
     */
    public function getBusinessFlightDepartureDate()
    {
        return empty($this->business_flight_departure_date) ?
            null : $this->business_flight_departure_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }



    /**
     * @return array
     */
    public function getAirlinesAirCarriersAttributesStructure()
    {
        return  [
            'flight_arrival_date'        => $this->getBusinessFlightArrivalDate(),
            'flight_departure_date'      => $this->getBusinessFlightDepartureDate(),
            'airline_code'               => $this->business_airline_code,
            'airline_flight_number'      => $this->business_airline_flight_number,
            'flight_ticket_number'       => $this->business_flight_ticket_number,
            'flight_origin_city'         => $this->business_flight_origin_city,
            'flight_destination_city'    => $this->business_flight_destination_city,
            'airline_tour_operator_name' => $this->business_airline_tour_operator_name,
            ];
    }
}
