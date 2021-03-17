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
 * Trait FurnitureAttributes
 * @package Genesis\API\Traits\Request\Financial\Business
 *
 * @method $this setBusinessNameOfTheSupplier($value) Set number of the supplier
 */
trait FurnitureAttributes
{
    /**
     * The date when order was placed
     *
     * @var string $business_date_of_order
     */
    protected $business_date_of_order;

    /**
     * Date of the expected delivery
     *
     * @var string $business_delivery_date
     */
    protected $business_delivery_date;

    /**
     * The name of supplier
     *
     * @var string $business_name_of_the_supplier
     */
    protected $business_name_of_the_supplier;

    /**
     *  Set date when order was placed
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessDateOfOrder($value)
    {
        if ($value === null) {
            $this->business_date_of_order = null;

            return $this;
        }

        return $this->parseDate(
            'business_date_of_order',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_date_of_order.'
        );
    }

    /**
     *  Set date of the expected delivery
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBusinessDeliveryDate($value)
    {
        if ($value === null) {
            $this->business_delivery_date = null;

            return $this;
        }

        return $this->parseDate(
            'business_delivery_date',
            DateTimeFormat::getDateFormats(),
            (string) $value,
            'Invalid format for business_delivery_date.'
        );
    }

    /**
     * @return string
     */
    public function getBusinessDateOfOrder()
    {
        return empty($this->business_date_of_order) ?
            null : $this->business_date_of_order->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return string
     */
    public function getBusinessDeliveryDate()
    {
        return empty($this->business_delivery_date) ?
            null : $this->business_delivery_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return array
     */
    public function getFurnitureAttributesStructure()
    {
        return [
            'date_of_order'        => $this->getBusinessDateOfOrder(),
            'delivery_date'        => $this->getBusinessDeliveryDate(),
            'name_of_the_supplier' => $this->business_name_of_the_supplier,
        ];
    }
}
