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

namespace Genesis\Api\Request\NonFinancial\Alternatives\Trustly;

use Genesis\Api\Request\Base\NonFinancial\Alternatives\Trustly\BaseRequest;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Country;

/**
 * Class SelectAccount
 * @package Genesis\Api\Request\NonFinancial\Alternatives\Trustly
 *
 * @method string getCountry()
 * @method string getFailureUrl()
 * @method string getIpAddress()
 * @method string getLocale()
 * @method string getSuccessUrl()
 * @method string getUniqueId()
 * @method $this  setFailureUrl($value)
 * @method $this  setIpAddress($value)
 * @method $this  setLocale($value)
 * @method $this  setSuccessUrl($value)
 * @method $this  setUniqueId($value)
 */
class SelectAccount extends BaseRequest
{
    /**
     * Country code in ISO 3166
     *
     * @var string
     */
    protected $country;

    /**
     * IP address of the customer
     *
     * @var string
     */
    protected $ip_address;

    /**
     * Unique identifier defined by merchant
     *
     * @var string
     */
    protected $unique_id;

    /**
     * URL where the customer is sent to after successful authentication
     *
     * @var string
     */
    protected $success_url;

    /**
     * URL where the customer is sent to after failed authentication
     *
     * @var string
     */
    protected $failure_url;

    /**
     * Customer's localization preference
     *
     * @var string
     */
    protected $locale;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct('select_account');
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'country',
            'first_name',
            'last_name',
            'ip_address',
            'email',
            'mobile_phone',
            'national_id',
            'birth_date',
            'success_url',
            'failure_url',
            'user_id',
            'unique_id',
            'locale'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'country' => Country::getList()
        ];

        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'country'      => $this->country,
            'first_name'   => $this->first_name,
            'last_name'    => $this->last_name,
            'ip_address'   => $this->ip_address,
            'email'        => $this->email,
            'mobile_phone' => $this->mobile_phone,
            'national_id'  => $this->national_id,
            'birth_date'   => $this->getBirthDate(),
            'success_url'  => $this->success_url,
            'failure_url'  => $this->failure_url,
            'user_id'      => $this->user_id,
            'unique_id'    => $this->unique_id,
            'locale'       => $this->locale
        ];
    }
}
