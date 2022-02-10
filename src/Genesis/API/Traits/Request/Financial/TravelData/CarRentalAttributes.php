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

use Genesis\API\Constants\DateTimeFormat;

/**
 * Trait CarRentalAttributes
 * @package Genesis\API\Traits\Request\Financial\TravelData
 */
trait CarRentalAttributes
{
    /**
     * @var string Rental Agreement Number / Hotel Folio Number.
     */
    protected $car_rental_purchase_identifier;

    /**
     * The car rental classification. Allowed values: 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,
     * 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 9999
     *
     * @var string
     */
    protected $car_rental_class_id;

    /**
     * Car rental Pick-up date.
     *
     * @var \DateTime
     */
    protected $car_rental_pickup_date;

    /**
     * @var string The Renter Name
     */
    protected $car_rental_renter_name;

    /**
     * @var string The Rental Return City
     */
    protected $car_rental_return_city;

    /**
     * @var string The Rental Return State
     */
    protected $car_rental_return_state;

    /**
     * @var string The Rental Return Country
     */
    protected $car_rental_return_country;

    /**
     * Car Rental return date
     *
     * @var \DateTime
     */
    protected $car_rental_return_date;

    /**
     * @var string Expenses or Car Rental code, Address, phone number, etc. Identifying Rental Return Location.
     */
    protected $car_rental_renter_return_location_id;

    /**
     * @var string The customer code. Internal Reference.
     */
    protected $car_rental_customer_code;

    /**
     * Additional charges added to customer bill after check-out.
     * Each position can be used to indicate a type of charge; Allowed values: 1, 2, 3, 4, 5
     *
     * @var string
     */
    protected $car_rental_extra_charges;

    /**
     * No show indicator; Allowed values: 0, 1
     *
     * @var string
     */
    protected $car_rental_no_show_indicator;

    public function setCarRentalPickupDate($value)
    {
        if (empty($value)) {
            $this->car_rental_pickup_date = null;

            return $this;
        }

        return $this->parseDate(
            'car_rental_pickup_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid value given for car_rental_pickup_date.'
        );
    }

    /**
     * @return string|null
     */
    public function getCarRentalPickupDate()
    {
        return (empty($this->car_rental_pickup_date)) ? null :
            $this->car_rental_pickup_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    public function setCarRentalReturnDate($value)
    {
        if (empty($value)) {
            $this->car_rental_return_date = null;

            return $this;
        }

        return $this->parseDate(
            'car_rental_return_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid value given for car_rental_return_date.'
        );
    }

    /**
     * @return string|null
     */
    public function getCarRentalReturnDate()
    {
        return (empty($this->car_rental_return_date)) ? null :
            $this->car_rental_return_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return array
     */
    public function getCarRentalStructure()
    {
        return [
            'car_rental' => [
                'purchase_identifier'       => $this->car_rental_purchase_identifier,
                'class_id'                  => $this->car_rental_class_id,
                'pickup_date'               => $this->getCarRentalPickupDate(),
                'renter_name'               => $this->car_rental_renter_name,
                'return_city'               => $this->car_rental_return_city,
                'return_state'              => $this->car_rental_return_city,
                'return_country'            => $this->car_rental_return_country,
                'return_date'               => $this->getCarRentalReturnDate(),
                'renter_return_location_id' => $this->car_rental_renter_return_location_id,
                'customer_code'             => $this->car_rental_customer_code,
                'extra_charges'             => $this->car_rental_extra_charges,
                'no_show_indicator'         => $this->car_rental_no_show_indicator,
            ]
        ];
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setCarRentalNoShowIndicator($value)
    {
        return $this->allowedOptionsSetter(
            'car_rental_no_show_indicator',
            [ 0, 1 ],
            $value,
            'Invalid no show indicator.'
        );
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setCarRentalExtraCharges($value)
    {
        return $this->allowedOptionsSetter(
            'car_rental_extra_charges',
            [ 1, 2, 3, 4, 5 ],
            $value,
            'Invalid extra charges.'
        );
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setCarRentalClassId($value)
    {
        return $this->allowedOptionsSetter(
            'car_rental_class_id',
            [
                1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22,
                23, 24, 25, 26, 27, 28, 29, 30, 9999
            ],
            $value,
            'Invalid class id. Check documentation for more information.'
        );
    }
}
