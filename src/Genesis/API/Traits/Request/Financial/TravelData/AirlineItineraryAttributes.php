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

namespace Genesis\API\Traits\Request\Financial\TravelData;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Request\Financial\TravelData\Base\AidAttributes;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait AirlineItineraryAttributes
 * @package Genesis\API\Traits\Request\Financial\TravelData
 *
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
     * @var string An entry should be supplied if a travel agency issued the ticket.
     */
    protected $aid_confirmation_information;

    /**
     * An entry should be supplied if a travel agency issued the ticket.
     *
     * @var \DateTime
     */
    protected $aid_date_of_issue;

    /**
     * @var array
     */
    protected $legs = [];

    /**
     * @var array
     */
    protected $taxes = [];

    /**
     * @return string|null
     */
    public function getAidDateOfIssue()
    {
        return (empty($this->aid_date_of_issue)) ? null :
            $this->aid_date_of_issue->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setAidDateOfIssue($value)
    {
        if (empty($value)) {
            $this->aid_date_of_issue = null;

            return $this;
        }

        return $this->parseDate(
            'aid_date_of_issue',
            DateTimeFormat::getAll(),
            $value,
            'Invalid value given for aid_date_of_issue.'
        );
    }

    /**
     * @return array
     */
    public function getAirlineItineraryStructure()
    {
        return  [
            'ticket_number'               => $this->aid_ticket_number,
            'passenger_name'              => $this->aid_passenger_name,
            'customer_code'               => $this->aid_customer_code,
            'restricted_ticket_indicator' => $this->aid_restricted_ticket_indicator,
            'issuing_carrier'             => $this->aid_issuing_carrier,
            'total_fare'                  => $this->transformAmount($this->aid_total_fare, $this->currency),
            'agency_name'                 => $this->aid_agency_name,
            'agency_code'                 => $this->aid_agency_code,
            'confirmation_information'    => $this->aid_confirmation_information,
            'date_of_issue'               => $this->getAidDateOfIssue()
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

    public function getTaxesStructure()
    {
        $taxes = [];

        foreach ($this->taxes as $tax) {
            $taxes[] = ['tax' => $tax->toArray()];
        }

        return $taxes;
    }

    /**
     * @param AidAttributes $item
     * @return $this
     * @throws InvalidArgument
     */
    public function addAdditionalAidAttributes(AidAttributes $item)
    {

        $structureName = $item->getStructureName();
        if (count($this->{$structureName}) === $item->getMaxCount()) {
            throw new InvalidArgument('Max '. $structureName .' count of ' . $item->getMaxCount() . ' reached.');
        }
        $this->{$structureName}[] = $item;

        return $this;
    }

    /**
     * Removes all legs
     */
    public function clearLegs()
    {
        $this->legs = [];
    }

    public function clearTaxes()
    {
        $this->taxes = [];
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

    /**
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setAidTotalFare($value)
    {
        return $this->parseAmount('aid_total_fare', $value);
    }
}
