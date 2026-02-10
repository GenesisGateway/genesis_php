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
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\NonFinancial\Payee;

/**
 * Trait AddressAttributes
 *
 * @method string getAddressCity()          Get the city of the address
 * @method string getAddressStreet()        Get the street of the address
 * @method string getAddressState()         Get the state of the address
 * @method string getAddressCountry()       Get the country of the address in ISO 3166
 * @method string getAddressZipCode()       Get the ZIP code of the address
 * @method $this  setAddressCity($value)    Set the city of the address
 * @method $this  setAddressStreet($value)  Set the street of the address
 * @method $this  setAddressState($value)   Set the state of the address
 * @method $this  setAddressCountry($value) Set the country of the address in ISO 3166
 * @method $this  setAddressZipCode($value) Set the ZIP code of the address
 *
 * @package Genesis\Api\Traits\Request\NonFinancial\Payee
 */
trait AddressAttributes
{
    /**
     * The city of the address
     *
     * @var string
     */
    protected $address_city;

    /**
     * The street of the address
     *
     * @var string
     */
    protected $address_street;

    /**
     * The state of the address
     *
     * @var string
     */
    protected $address_state;

    /**
     * The country of the address in ISO 3166
     *
     * @var string
     */
    protected $address_country;

    /**
     * The ZIP code of the address
     *
     * @var string
     */
    protected $address_zip_code;

    /**
     * Get address attributes structure
     *
     * @return array
     */
    protected function getAddressAttributesStructure()
    {
        return [
            'city'     => $this->address_city,
            'street'   => $this->address_street,
            'state'    => $this->address_state,
            'country'  => $this->address_country,
            'zip_code' => $this->address_zip_code
        ];
    }
}
