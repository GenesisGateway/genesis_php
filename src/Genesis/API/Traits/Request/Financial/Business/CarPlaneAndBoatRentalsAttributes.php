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
 * Trait CarPlaneAndBoatRentalsAttributes
 * @package Genesis\API\Traits\Request\Financial\Business
 *
 * @method $this setBusinessSupplierName($value) Set name of supplier/contractor
 */
trait CarPlaneAndBoatRentalsAttributes
{
    /**
     * The date when customer takes the vehicle
     *
     * @var string $business_vehicle_pick_up_date
     */
    protected $business_vehicle_pick_up_date;

    /**
     * The date when the customer returns the vehicle back
     *
     * @var string $business_vehicle_return_date
     */
    protected $business_vehicle_return_date;

    /**
     * The name of supplier/contractor
     *
     * @var string $business_supplier_name
     */
    protected $business_supplier_name;

    /**
     *  Set date when customer takes the vehicle
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessVehiclePickUpDate($value)
    {
        if ($value === null) {
            $this->business_vehicle_pick_up_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_vehicle_pick_up_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_vehicle_pick_up_date.'
        );
    }

    /**
     *  Set date when the customer returns the vehicle back
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessVehicleReturnDate($value)
    {
        if ($value === null) {
            $this->business_vehicle_return_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_vehicle_return_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_vehicle_return_date.'
        );
    }

    /**
     * @return string
     */
    public function getBusinessVehiclePickUpDate()
    {
        return empty($this->business_vehicle_pick_up_date) ?
            null : $this->business_vehicle_pick_up_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return string
     */
    public function getBusinessVehicleReturnDate()
    {
        return empty($this->business_vehicle_return_date) ?
            null : $this->business_vehicle_return_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return array
     */
    public function getCarPlaneAndBoatRentalsAttributesStructure()
    {
        return [
            'vehicle_pick_up_date' => $this->getBusinessVehiclePickUpDate(),
            'vehicle_return_date'  => $this->getBusinessVehicleReturnDate(),
            'supplier_name'        => $this->business_supplier_name
        ];
    }
}
