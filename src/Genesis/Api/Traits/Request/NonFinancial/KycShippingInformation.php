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
 * @copyright   Copyright (C) 2015-2024 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\NonFinancial;

/**
 * Trait KycShippingInformation
 * @package Genesis\Api\Traits\Request\NonFinancial
 */
trait KycShippingInformation
{
    /**
     * @var string
     */
    protected $kyc_shipping_first_name;

    /**
     * @var string
     */
    protected $kyc_shipping_last_name;

    /**
     * @var string
     */
    protected $kyc_shipping_customer_email;

    /**
     * @var string
     */
    protected $kyc_shipping_address1;

    /**
     * @var string
     */
    protected $kyc_shipping_address2;

    /**
     * @var string
     */
    protected $kyc_shipping_city;

    /**
     * @var string
     */
    protected $kyc_shipping_zip_code;

    /**
     * two-letter iso codes
     *
     * @var string
     */
    protected $kyc_shipping_country;

    /**
     * @var string
     */
    protected $kyc_shipping_province;

    /**
     * @var string
     */
    protected $kyc_shipping_phone1;

    /**
     * @return array
     */
    public function getKycShippingStructure()
    {
        return [
            'first_name'     => $this->kyc_shipping_first_name,
            'last_name'      => $this->kyc_shipping_last_name,
            'customer_email' => $this->kyc_shipping_customer_email,
            'address1'       => $this->kyc_shipping_address1,
            'address2'       => $this->kyc_shipping_address2,
            'city'           => $this->kyc_shipping_city,
            'zip_code'       => $this->kyc_shipping_zip_code,
            'country'        => $this->kyc_shipping_country,
            'province'       => $this->kyc_shipping_province,
            'phone1'         => $this->kyc_shipping_phone1
        ];
    }
}
