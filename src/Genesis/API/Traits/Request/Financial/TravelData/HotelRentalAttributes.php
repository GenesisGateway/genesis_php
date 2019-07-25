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

/**
 * Trait HotelRentalAttributes
 * @package Genesis\API\Traits\Request\Financial\TravelData
 */
trait HotelRentalAttributes
{
    /**
     * Rental Agreement Number / Hotel Folio Number.
     *
     * @var string
     */
    protected $hotel_rental_purchase_identifier;

    /**
     * Hotel check-in date.
     *
     * @var string
     */
    protected $hotel_rental_arrival_date;

    /**
     * The departure date. Date can be in future.
     *
     * @var string
     */
    protected $hotel_rental_departure_date;

    /**
     * The customer code. Internal Reference.
     *
     * @var string
     */
    protected $hotel_rental_customer_code;

    /**
     * Additional charges added to customer bill after check-out.
     * Each position can be used to indicate a type of charge. Allowed values: 2, 3, 4, 5, 6, 7
     *
     * @var string
     */
    protected $hotel_rental_extra_charges;

    /**
     * No show indicator; Allowed values: 0, 1
     *
     * @var string
     */
    protected $hotel_rental_no_show_indicator;

    /**
     * @return array
     */
    public function getHotelRentalStructure()
    {
        return [
            'rentals' => [
                'hotel_rental' => [
                    'purchase_identifier' => $this->hotel_rental_purchase_identifier,
                    'arrival_date'        => $this->hotel_rental_arrival_date,
                    'departure_date'      => $this->hotel_rental_departure_date,
                    'customer_code'       => $this->hotel_rental_customer_code,
                    'extra_charges'       => $this->hotel_rental_extra_charges,
                    'no_show_indicator'   => $this->hotel_rental_no_show_indicator
                ]
            ]
        ];
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setHotelRentalNoShowIndicator($value)
    {
        return $this->allowedOptionsSetter(
            'hotel_rental_no_show_indicator',
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
    public function setHotelRentalExtraCharges($value)
    {
        return $this->allowedOptionsSetter(
            'hotel_rental_extra_charges',
            [ 2, 3, 4, 5, 6, 7 ],
            $value,
            'Invalid extra charges.'
        );
    }
}
