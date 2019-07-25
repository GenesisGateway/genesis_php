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

namespace Genesis\API\Request\Financial\TravelData;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\RestrictedSetter;
use Genesis\Exceptions\InvalidArgument;

/**
 * Class AirlineItineraryLegData
 * @package Genesis\API\Request\Financial\TravelData
 */
class AirlineItineraryLegData
{
    const DEPARTURE_TIME_SEGMENT_AM = 'A';
    const DEPARTURE_TIME_SEGMENT_PM = 'P';
    const STOPOVER_CODE_ALLOWED     = 1;
    const STOPOVER_CODE_DISALLOWED  = 0;

    use MagicAccessors, RestrictedSetter;

    /**
     * @var string
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
     * AirlineItineraryLegData constructor.
     *
     * @param $departureDate
     * @param $carrierCode
     * @param $serviceClass
     * @param $originCity
     * @param $destinationCity
     * @param $stopoverCode
     *
     * @throws InvalidArgument
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        $departureDate,
        $carrierCode,
        $serviceClass,
        $originCity,
        $destinationCity,
        $stopoverCode
    ) {
        $this->setDepartureDate($departureDate);
        $this->setCarrierCode($carrierCode);
        $this->setServiceClass($serviceClass);
        $this->setOriginCity($originCity);
        $this->setDestinationCity($destinationCity);
        $this->setStopOverCode($stopoverCode);
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryLegData
     * @throws InvalidArgument
     */
    public function setDepartureDate($value)
    {
        return $this->setLimitedString('departureDate', $value, 1, 10);
    }

    /**
     * @param $value
     *
     * @return AirlineItineraryLegData
     * @throws InvalidArgument
     */
    public function setCarrierCode($value)
    {
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
     * @param $stopoverCode
     *
     * @return AirlineItineraryLegData
     * @throws InvalidArgument
     */
    public function setStopoverCode($stopoverCode)
    {
        return $this->allowedOptionsSetter(
            'stopoverCode',
            [
                self::STOPOVER_CODE_ALLOWED,
                self::STOPOVER_CODE_DISALLOWED
            ],
            $stopoverCode,
            'Invalid stopover code.'
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'departure_date'         => $this->departureDate,
            'carrier_code'           => $this->carrierCode,
            'service_class'          => $this->serviceClass,
            'origin_city'            => $this->originCity,
            'destination_city'       => $this->destinationCity,
            'stopover_code'          => $this->stopoverCode,
            'fare_basis_code'        => $this->fareBasisCode,
            'flight_number'          => $this->flightNumber,
            'departure_time'         => $this->departureTime,
            'departure_time_segment' => $this->departureTimeSegment
        ];
    }
}
