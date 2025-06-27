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
use Genesis\Utils\Common;
use Genesis\Utils\Country;

/**
 * Create a Payee record.
 *
 * @package Genesis\Api\Request\NonFinancial\Payee
 *
 * @method $this setPayeeType(string $value)         Sets the type of the Payee (company or person)
 * @method $this setPayeeName(string $value)         Sets the full name of the Payee
 * @method $this setPayeeCountry(string $value)      Sets the country code of the Payee in ISO 3166 format
 * @method string getPayeeType()                     Returns the type of the Payee
 * @method string getPayeeName()                     Returns the full name of the Payee
 * @method string getPayeeCountry()                  Returns the country code of the Payee in ISO 3166 format
 *
 */
class Create extends BaseRequest
{
    /**
     * The type of the Payee. Can be company or person.
     *
     * @var string
     */
    protected $payee_type;

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
     * Create constructor.
     */
    public function __construct()
    {
        parent::__construct('payee');
    }

    /**
     * Set validation rules for required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields       = [
            'payee_type',
            'payee_name',
            'payee_country'
        ];
        $this->requiredFields = Common::createArrayObject($requiredFields);

        $requiredFieldValues       = [
            'payee_type'    => ['company', 'person'],
            'payee_country' => Country::getList()
        ];
        $this->requiredFieldValues = Common::createArrayObject($requiredFieldValues);
    }

    /**
     * Get the request structure for the API call
     *
     * @return array[]
     */
    protected function getRequestStructure()
    {
        return [
            'payee' => [
                'type'    => $this->payee_type,
                'name'    => $this->payee_name,
                'country' => $this->payee_country
            ]
        ];
    }
}
