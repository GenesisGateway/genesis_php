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

namespace Genesis\Api\Request\NonFinancial\Kyc\Business;

use Genesis\Api\Request\Base\NonFinancial\Kyc\BaseRequest as KYCBaseRequest;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Country;

/**
 * Class CreateBusiness
 *
 * Create a Business record.
 *
 * @package Genesis\Api\Request\NonFinancial\Kyc\Business
 */
class CreateBusiness extends KYCBaseRequest
{
    /**
     * The registration number of the business.
     *
     * @var string
     *
     */
    protected $registration_number;

    /**
     * Country code in ISO 3166 where the business is restarted.
     *
     * @var string
     *
     */
    protected $country;

    /**
     * The name of the business.
     *
     * @var string
     *
     */
    protected $name;

    /**
     * CreateBusiness constructor
     *
     */
    public function __construct()
    {
        parent::__construct('businesses');
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields       = [
            'registration_number',
            'country'
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues       = [
            'country' => Country::getList(),
        ];
        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }

    /**
     * Create the request's Tree structure
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'registration_number' => $this->registration_number,
            'country'             => $this->country,
            'name'                => $this->name
        ];
    }
}
