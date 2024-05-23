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

namespace Genesis\Api\Traits\Request\Financial;

/**
 * Trait DescriptorAttributes
 *
 * Trait for Transactions with Dynamic Descriptor Params
 *
 * @package Genesis\Api\Traits\Request\Financial
 *
 * @method $this setDynamicMerchantName( $value ) Dynamically override the charge descriptor
 * @method $this setDynamicMerchantCity( $value ) Dynamically override the merchant phone number
 * @method $this setDynamicSubMerchantId( $value ) Sub-merchant ID assigned by the Payment Facilitator
 * @method $this setDynamicMerchantCountry( $value ) Dynamically override the merchant country
 * @method $this setDynamicMerchantState( $value ) Dynamically override the merchant subdivision code
 * @method $this setDynamicMerchantZipCode( $value ) Dynamically override the merchant zip/postal code
 * @method $this setDynamicMerchantAddress( $value ) Dynamically override the merchant address
 * @method $this setDynamicMerchantUrl( $value ) Dynamically override the merchant URL
 * @method $this setDynamicMerchantPhone( $value ) Dynamically override the merchant phone number
 * @method $this setDynamicMerchantServiceCity( $value ) Dynamically override the merchant service city
 * @method $this setDynamicMerchantServiceCountry( $value ) Dynamically override the merchant service country
 * @method $this setDynamicMerchantServiceState( $value ) Dynamically override the merchant service subdivision code
 * @method $this setDynamicMerchantServiceZipCode( $value ) Dynamically override the merchant service zip/postal
 * @method $this setDynamicMerchantServicePhone( $value ) Dynamically override the merchant service phone number
 */
trait DescriptorAttributes
{
    /**
     * Allows to dynamically override the charge descriptor
     *
     * @var string
     */
    protected $dynamic_merchant_name;

    /**
     * Allows to dynamically override the merchant phone number
     *
     * @var string
     */
    protected $dynamic_merchant_city;

    /**
     * Sub-merchant ID assigned by the Payment Facilitator
     *
     * @var string $dynamic_sub_merchant_id
     */
    protected $dynamic_sub_merchant_id;

    /**
     * Allows to dynamically override the merchant country.
     *
     * @var string $dynamic_merchant_country
     */
    protected $dynamic_merchant_country;

    /**
     * Allows to dynamically override the merchant subdivision code.
     *
     * @var string $dynamic_merchant_state
     */
    protected $dynamic_merchant_state;

    /**
     * Allows to dynamically override the merchant zip/postal code.
     *
     * @var string $dynamic_merchant_zip_code
     */
    protected $dynamic_merchant_zip_code;

    /**
     * Allows to dynamically override the merchant address.
     *
     * @var string $dynamic_merchant_address
     */
    protected $dynamic_merchant_address;

    /**
     * Allows to dynamically override the merchant URL
     *
     * @var string $dynamic_merchant_url
     */
    protected $dynamic_merchant_url;

    /**
     * Allows to dynamically override the merchant phone number.
     *
     * @var string $dynamic_merchant_phone
     */
    protected $dynamic_merchant_phone;

    /**
     * Allows to dynamically override the merchant service city.
     *
     * @var string $dynamic_merchant_service_city
     */
    protected $dynamic_merchant_service_city;

    /**
     * Allows to dynamically override the merchant service country.
     *
     * @var string $dynamic_merchant_service_country
     */
    protected $dynamic_merchant_service_country;

    /**
     * Allows to dynamically override the merchant service subdivision code.
     *
     * @var string $dynamic_merchant_service_state
     */
    protected $dynamic_merchant_service_state;

    /**
     * Allows to dynamically override the merchant service zip/postal code.
     *
     * @var string $dynamic_merchant_service_zip_code
     */
    protected $dynamic_merchant_service_zip_code;

    /**
     * Allows to dynamically override the merchant service phone number.
     *
     * @var string $dynamic_merchant_service_phone
     */
    protected $dynamic_merchant_service_phone;

    /**
     * Builds an array list with all Params
     *
     * @return array
     */
    protected function getDynamicDescriptorParamsStructure()
    {
        return [
            'merchant_name'             => $this->dynamic_merchant_name,
            'merchant_city'             => $this->dynamic_merchant_city,
            'sub_merchant_id'           => $this->dynamic_sub_merchant_id,
            'merchant_country'          => $this->dynamic_merchant_country,
            'merchant_state'            => $this->dynamic_merchant_state,
            'merchant_zip_code'         => $this->dynamic_merchant_zip_code,
            'merchant_address'          => $this->dynamic_merchant_address,
            'merchant_url'              => $this->dynamic_merchant_url,
            'merchant_phone'            => $this->dynamic_merchant_phone,
            'merchant_service_city'     => $this->dynamic_merchant_service_city,
            'merchant_service_country'  => $this->dynamic_merchant_service_country,
            'merchant_service_state'    => $this->dynamic_merchant_service_state,
            'merchant_service_zip_code' => $this->dynamic_merchant_service_zip_code,
            'merchant_service_phone'    => $this->dynamic_merchant_service_phone
        ];
    }
}
