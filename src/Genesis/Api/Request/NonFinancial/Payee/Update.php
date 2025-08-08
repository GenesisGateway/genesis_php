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
 * @copyright   Copyright (C) 2015-2025 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Request\NonFinancial\Payee;

use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\PayeeAttributes;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Country;

/**
 * Update a Payee record
 *
 * @package Genesis\Api\Request\NonFinancial\Payee
 *
 * @method $this  setPayeeName(string $value)         Sets the full name of the Payee
 * @method string getPayeeName()                      Returns the full name of the Payee
 * @method string getPayeeCountry()                   Returns the country code of the Payee in ISO 3166 format
 *
 */
class Update extends BaseRequest
{
    use PayeeAttributes;

    const REQUEST_PATH = 'payee/:payee_unique_id';

    /**
     * The Payee full name.
     *
     * @var string
     */
    protected $payee_name;

    /**
     * Payee Country code in ISO 3166. In case of person this should contain the country of birth.
     * In case of company this should contain the country of incorporation.
     *
     * @var string
     */
    protected $payee_country;

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(self::REQUEST_PATH);
    }

    /**
     * Sets the payee country
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setPayeeCountry($value)
    {
        if (empty($value)) {
            $this->payee_country = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'payee_country',
            Country::getList(),
            $value,
            'Invalid Payee Country'
        );
    }

    /**
     * Updates the request path with payee_unique_id
     *
     * @throws EnvironmentNotSet
     */
    protected function updateRequestPath()
    {
        $this->setRequestPath(
            str_replace(
                ':payee_unique_id',
                (string)$this->payee_unique_id,
                self::REQUEST_PATH
            )
        );
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'payee_unique_id'
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * Configures a Secured Patch Request with JSON body
     *
     * @return void
     */
    protected function initJsonConfiguration()
    {
        $this->setPatchRequest();
    }

    /**
     * Returns the request structure
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'payee' => [
                'name'    => $this->payee_name,
                'country' => $this->payee_country
            ]
        ];
    }
}
