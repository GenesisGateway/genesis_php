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
 * Trait BillingInfoAttributes
 * @package Genesis\API\Traits\Request\CustomerAddress
 *
 * @method $this setBillingFirstName($value) Set Customer's Billing Address: First name
 * @method $this setBillingLastName($value) Set Customer's Billing Address: First name
 * @method $this setBillingAddress1($value) Set Customer's Billing Address: Part 1
 * @method $this setBillingAddress2($value) Set Customer's Billing Address: Part 2
 * @method $this setBillingZipCode($value) Set Customer's Billing Address: ZIP
 * @method $this setBillingCity($value) Set Customer's Billing Address: City
 * @method $this setBillingState($value) Set Customer's Billing Address: State
 * @method $this setBillingCountry($value) Set Customer's Billing Address: Country
 */
trait BillingInfoAttributes
{
    /**
     * Customer's Billing Address: First name
     *
     * @var string
     */
    protected $billing_first_name;

    /**
     * Customer's Billing Address: Last name
     *
     * @var string
     */
    protected $billing_last_name;

    /**
     * Customer's Billing Address: Part 1
     *
     * @var string
     */
    protected $billing_address1;

    /**
     * Customer's Billing Address: Part 2
     * @var string
     */
    protected $billing_address2;

    /**
     * Customer's Billing Address: ZIP
     *
     * @var string
     */
    protected $billing_zip_code;

    /**
     * Customer's Billing Address: City
     *
     * @var string
     */
    protected $billing_city;

    /**
     * Customer's Billing Address: State
     *
     * format: ISO-3166-2
     *
     * @var string
     */
    protected $billing_state;

    /**
     * Customer's Billing Address: Country
     *
     * format: ISO-3166
     *
     * @var string
     */
    protected $billing_country;

    /**
     * Builds an array list with all Params
     *
     * @return array
     */
    protected function getBillingAddressParamsStructure()
    {
        return [
            'first_name' => $this->billing_first_name,
            'last_name'  => $this->billing_last_name,
            'address1'   => $this->billing_address1,
            'address2'   => $this->billing_address2,
            'zip_code'   => $this->billing_zip_code,
            'city'       => $this->billing_city,
            'state'      => $this->billing_state,
            'country'    => $this->billing_country
        ];
    }
}
