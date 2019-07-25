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

namespace Genesis\API\Traits\Request\Financial\TravelData;

use Genesis\API\Request\Financial\TravelData\AirlineItineraryLegData;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait AirlineItineraryAttributes
 * @package Genesis\API\Traits\Request\Financial\TravelData
 */
trait AirlineItineraryAttributes
{
    /**
     * @var string The number on the ticket.
     */
    protected $aid_ticket_number;

    /**
     * @var string The name of the passenger. May be the cardholder name
     * if the passenger name is unavailable. Must not be blank.
     */
    protected $aid_passenger_name;

    /**
     * @var string The customer code. Internal Reference.
     */
    protected $aid_customer_code;

    /**
     * @var string Space or 0 = No restriction, 1 = Restriction; Allowed values: Empty String, 0, 1
     */
    protected $aid_restricted_ticket_indicator;

    /**
     * @var string Contains the standard abbreviation for the airline or railway carrier issuing the ticket.
     */
    protected $aid_issuing_carrier;

    /**
     * @var int Total amount of the ticket and should equal the amount of the transaction.
     */
    protected $aid_total_fare;

    /**
     * @var string An entry should be supplied if a travel agency issued the ticket.
     */
    protected $aid_agency_name;

    /**
     * @var string An entry should be supplied if a travel agency issued the ticket.
     */
    protected $aid_agency_code;

    /**
     * @var array
     */
    protected $legs = [];

    /**
     * @return int
     */
    public static function getMaxLegsCount()
    {
        return 10;
    }

    /**
     * @return array
     */
    public function getAirlineItineraryStructure()
    {
        return [
            'ticket' => [
                'ticket_number'               => $this->aid_ticket_number,
                'passenger_name'              => $this->aid_passenger_name,
                'customer_code'               => $this->aid_customer_code,
                'restricted_ticket_indicator' => $this->aid_restricted_ticket_indicator,
                'issuing_carrier'             => $this->aid_issuing_carrier,
                'total_fare'                  => $this->aid_total_fare,
                'agency_name'                 => $this->aid_agency_name,
                'agency_code'                 => $this->aid_agency_code
            ],
            'legs'   => $this->getLegsStructure()
        ];
    }

    public function getLegsStructure()
    {
        $legs = [];
        foreach ($this->legs as $leg) {
            $legs[] = ['leg' => $leg->toArray()];
        }

        return $legs;
    }

    /**
     * @param AirlineItineraryLegData $leg
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function addLeg(AirlineItineraryLegData $leg)
    {
        if (count($this->legs) === $this->getMaxLegsCount()) {
            throw new InvalidArgument('Max legs count of ' . $this->getMaxLegsCount() . ' reached.');
        }
        $this->legs[] = $leg;

        return $this;
    }

    /**
     * Removes all legs
     */
    public function clearLegs()
    {
        $this->legs = [];
    }

    public function setAidRestrictedTicketIndicator($value)
    {
        return $this->allowedOptionsSetter(
            'aid_restricted_ticket_indicator',
            [ '', 0, 1 ],
            $value,
            'Invalid restricted ticket indicator.'
        );
    }
}
