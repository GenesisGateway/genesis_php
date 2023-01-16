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

namespace Genesis\API\Request\Financial\TravelData;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Traits\MagicAccessors;
use Genesis\Exceptions\InvalidArgument;
use Genesis\API\Request\Financial\TravelData\Base\AidAttributes;

/**
 * Class AirlineItineraryLegData
 * @package Genesis\API\Request\Financial\TravelData
 */
class AirlineItineraryLegData extends AidAttributes
{
    const DEPARTURE_TIME_SEGMENT_AM = 'A';
    const DEPARTURE_TIME_SEGMENT_PM = 'P';
    const STOPOVER_CODE_ALLOWED     = 1;
    const STOPOVER_CODE_DISALLOWED  = 0;

    use MagicAccessors;

    /**
     * @var \DateTime
     */
    protected $departureDate;

    /**
     * @var string
     */
    protected $carrierCode;

    /**
     * @var string
     */
    protected $serviceClass;

    /**
     * @var string
     */
    protected $originCity;

    /**
     * @var string
     */
    protected $destinationCity;

    /**
     * @var string
     */
    protected $stopoverCode;

    /**
     * @var string
     */
    protected $fareBasisCode;

    /**
     * @var string
     */
    protected $flightNumber;

    /**
     * @var string
     */
    protected $departureTime;

    /**
     * @var string
     */
    protected $departureTimeSegment;

    /**
     * @var \DateTime
     */
    protected $arrivalDate;

    /**
     * AirlineItineraryLegData constructor.
     *
     * @param $departureDate
     * @param $carrierCode
     * @param $serviceClass
     * @param $originCity
     * @param $destinationCity
     * @param $stopoverCode
     *
     * @param $fareBasisCode
     * @param $arrivalDate
     * @throws InvalidArgument
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        $departureDate,
        $carrierCode = null,
        $serviceClass = null,
        $originCity = null,
        $destinationCity = null,
        $stopoverCode = null,
        $arrivalDate = null,
        $fareBasisCode = null
    ) {
        $this->setDepartureDate($departureDate);
        $this->setCarrierCode($carrierCode);
        $this->setServiceClass($serviceClass);
        $this->setOriginCity($originCity);
        $this->setDestinationCity($destinationCity);
        $this->setStopOverCode($stopoverCode);
        $this->setArrivalDate($arrivalDate);
        $this->setFareBasisCode($fareBasisCode);
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryLegData
     * @throws InvalidArgument
     */
    public function setDepartureDate($value)
    {
        if (empty($value)) {
            $this->departureDate = null;

            return $this;
        }

        return $this->parseDate(
            'departureDate',
            DateTimeFormat::getAll(),
            (string)$value,
            'Invalid format for departure date'
        );
    }

    /**
     * @return string|null
     */
    public function getDepartureDate()
    {
        return empty($this->departureDate) ?
            null : $this->departureDate->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryLegData
     * @throws InvalidArgument
     */
    public function setCarrierCode($value)
    {
        if ($value === null) {
            $this->carrierCode = null;

            return $this;
        }

        return $this->setLimitedString('carrierCode', $value, 1, 2);
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryLegData
     * @throws InvalidArgument
     */
    public function setServiceClass($value)
    {
        if ($value === null) {
            $this->serviceClass = null;

            return $this;
        }

        return $this->setLimitedString('serviceClass', $value, 1, 1);
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryLegData
     * @throws InvalidArgument
     */
    public function setOriginCity($value)
    {
        if ($value === null) {
            $this->originCity = null;

            return $this;
        }

        return $this->setLimitedString('originCity', $value, 1, 3);
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryLegData
     * @throws InvalidArgument
     */
    public function setDestinationCity($value)
    {
        if ($value === null) {
            $this->destinationCity = null;

            return $this;
        }

        return $this->setLimitedString('destinationCity', $value, 1, 3);
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryLegData
     * @throws InvalidArgument
     */
    public function setFareBasisCode($value)
    {
        if ($value === null) {
            $this->fareBasisCode = null;

            return $this;
        }

        return $this->setLimitedString('fareBasisCode', $value, null, 6);
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryLegData
     * @throws InvalidArgument
     */
    public function setFlightNumber($value)
    {
        if ($value === null) {
            $this->flightNumber = null;

            return $this;
        }

        return $this->setLimitedString('flightNumber', $value, null, 5);
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryLegData
     * @throws InvalidArgument
     */
    public function setDepartureTime($value)
    {
        if ($value === null) {
            $this->departureTime = null;

            return $this;
        }

        return $this->setLimitedString('departureTime', $value, null, 5);
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryLegData
     * @throws InvalidArgument
     */
    public function setDepartureTimeSegment($value)
    {
        if ($value === null) {
            $this->departureTimeSegment = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'departureTimeSegment',
            [
                self::DEPARTURE_TIME_SEGMENT_AM,
                self::DEPARTURE_TIME_SEGMENT_PM
            ],
            $value,
            'Invalid departure time segment.'
        );
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryLegData
     * @throws InvalidArgument
     */
    public function setStopoverCode($value)
    {
        if ($value === null) {
            $this->stopoverCode = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'stopoverCode',
            [
                self::STOPOVER_CODE_ALLOWED,
                self::STOPOVER_CODE_DISALLOWED
            ],
            $value,
            'Invalid stopover code.'
        );
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryLegData
     * @throws InvalidArgument
     */
    public function setArrivalDate($value)
    {
        if (empty($value)) {
            $this->arrivalDate = null;

            return $this;
        }

        return $this->parseDate(
            'arrivalDate',
            DateTimeFormat::getAll(),
            $value,
            'Invalid format for arrival date:'
        );
    }

    /**
     * @return string|null
     */
    public function getArrivalDate()
    {
        return empty($this->arrivalDate) ?
            null : $this->arrivalDate->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    public function getStructureName()
    {
        return 'legs';
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'departure_date'         => $this->getDepartureDate(),
            'carrier_code'           => $this->carrierCode,
            'service_class'          => $this->serviceClass,
            'origin_city'            => $this->originCity,
            'destination_city'       => $this->destinationCity,
            'stopover_code'          => $this->stopoverCode,
            'fare_basis_code'        => $this->fareBasisCode,
            'flight_number'          => $this->flightNumber,
            'departure_time'         => $this->departureTime,
            'departure_time_segment' => $this->departureTimeSegment,
            'arrival_date'           => $this->getArrivalDate()
        ];
    }
}
