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

namespace Genesis\API\Traits\Request;

/**
 * Trait AddressInfoAttributes
 * @package Genesis\API\Traits\Request
 *
 * @method $this setCustomerEmail($value) Set Email address of the Customer
 * @method $this setCustomerPhone($value) Set Phone number of the Customer

 * @method $this setBillingFirstName($value) Set Customer's Billing Address: First name
 * @method $this setBillingLastName($value) Set Customer's Billing Address: First name
 * @method $this setBillingAddress1($value) Set Customer's Billing Address: Part 1
 * @method $this setBillingAddress2($value) Set Customer's Billing Address: Part 2
 * @method $this setBillingZipCode($value) Set Customer's Billing Address: ZIP
 * @method $this setBillingCity($value) Set Customer's Billing Address: City
 * @method $this setBillingState($value) Set Customer's Billing Address: State
 * @method $this setBillingCountry($value) Set Customer's Billing Address: Country

 * @method $this setShippingFirstName($value) Set Customer's Shipping Address: First name
 * @method $this setShippingLastName($value) Set Customer's Shipping Address: First name
 * @method $this setShippingAddress1($value) Set Customer's Shipping Address: Part 1
 * @method $this setShippingAddress2($value) Set Customer's Shipping Address: Part 2
 * @method $this setShippingZipCode($value) Set Customer's Shipping Address: ZIP
 * @method $this setShippingCity($value) Set Customer's Shipping Address: City
 * @method $this setShippingState($value) Set Customer's Shipping Address: State
 * @method $this setShippingCountry($value) Set Customer's Shipping Address: Country
 */
trait AddressInfoAttributes
{
    /**
     * Email address of the Customer
     *
     * @var string
     */
    protected $customer_email;

    /**
     * Phone number of the customer
     *
     * @var string
     */
    protected $customer_phone;

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
}
