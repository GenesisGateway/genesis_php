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

namespace Genesis\API\Traits\Request\CustomerAddress;

/**
 * Trait ShippingInfoAttributes
 * @package Genesis\API\Traits\Request\CustomerAddress
 *
 * @method $this setShippingFirstName($value) Set Customer's Shipping Address: First name
 * @method $this setShippingLastName($value) Set Customer's Shipping Address: First name
 * @method $this setShippingAddress1($value) Set Customer's Shipping Address: Part 1
 * @method $this setShippingAddress2($value) Set Customer's Shipping Address: Part 2
 * @method $this setShippingZipCode($value) Set Customer's Shipping Address: ZIP
 * @method $this setShippingCity($value) Set Customer's Shipping Address: City
 * @method $this setShippingState($value) Set Customer's Shipping Address: State
 * @method $this setShippingCountry($value) Set Customer's Shipping Address: Country
 */
trait ShippingInfoAttributes
{
    /**
     * Customer's Shipping Address: First name
     *
     * @var string
     */
    protected $shipping_first_name;

    /**
     * Customer's Shipping Address: Last name
     *
     * @var string
     */
    protected $shipping_last_name;

    /**
     * Customer's Shipping Address: Part 1
     *
     * @var string
     */
    protected $shipping_address1;

    /**
     * Customer's Shipping Address: Part 2
     *
     * @var string
     */
    protected $shipping_address2;

    /**
     * Customer's Shipping Address: ZIP
     *
     * @var string
     */
    protected $shipping_zip_code;

    /**
     * Customer's Shipping Address: City
     *
     * @var string
     */
    protected $shipping_city;

    /**
     * Customer's Shipping Address: State
     *
     * format: ISO-3166-2
     *
     * @var string
     */
    protected $shipping_state;

    /**
     * Customer's Shipping Address
     *
     * format: ISO-3166
     *
     * @var string
     */
    protected $shipping_country;

    /**
     * Builds an array list with all Params
     *
     * @return array
     */
    protected function getShippingAddressParamsStructure()
    {
        return [
            'first_name' => $this->shipping_first_name,
            'last_name'  => $this->shipping_last_name,
            'address1'   => $this->shipping_address1,
            'address2'   => $this->shipping_address2,
            'zip_code'   => $this->shipping_zip_code,
            'city'       => $this->shipping_city,
            'state'      => $this->shipping_state,
            'country'    => $this->shipping_country
        ];
    }
}
