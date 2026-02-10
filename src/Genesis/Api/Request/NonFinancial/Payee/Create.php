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

namespace Genesis\Api\Request\NonFinancial\Payee;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Constants\NonFinancial\Payee\PayeeTypes;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\Payee\AddressAttributes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Country;
use DateTime;

/**
 * Class Create
 *
 * Create a Payee record.
 *
 * @package Genesis\Api\Request\NonFinancial\Payee
 *
 * @method $this  setPayeeType(string $value)                Sets the type of the Payee (company or person)
 * @method $this  setPayeeName(string $value)                Sets the full name of the Payee
 * @method $this  setPayeeCountry(string $value)             Sets the country code of the Payee in ISO 3166 format
 * @method $this  setPayeeNotificationUrl(string $value)     Sets the notification URL
 * @method $this  setPayeeRegistrationNumber(string $value)  Sets the registration number
 * @method string getPayeeType()                            Returns the type of the Payee
 * @method string getPayeeName()                            Returns the full name of the Payee
 * @method string getPayeeCountry()                         Returns the country code of the Payee
 * @method string getPayeeNotificationUrl()                 Returns the notification URL
 * @method string getPayeeRegistrationNumber()              Returns the registration number
 *
 */
class Create extends BaseRequest
{
    use AddressAttributes;

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
     * Date of birth for person or date of incorporation for company.
     *
     * @var DateTime|string
     */
    protected $payee_date;

    /**
     * The URL to which the Payee API will send notifications.
     *
     * @var string
     */
    protected $payee_notification_url;

    /**
     * The registration number of a company.
     *
     * @var string
     */
    protected $payee_registration_number;

    /**
     * Create constructor.
     */
    public function __construct()
    {
        parent::__construct('payee');
    }

    /**
     * Sets the payee date
     *
     * @param  string $value
     *
     * @return $this
     *
     * @throws InvalidArgument
     */
    public function setPayeeDate($value)
    {
        if (empty($value)) {
            $this->payee_date = null;

            return $this;
        }

        return $this->parseDate(
            'payee_date',
            DateTimeFormat::getAll(),
            (string)$value,
            'Invalid format for Owner date'
        );
    }

    /**
     * Gets the payee date
     *
     * @return string|null
     */
    public function getPayeeDate()
    {
        $format = $this->payee_date ? DateTimeFormat::YYYY_MM_DD_H_I_S :
            DateTimeFormat::YYYY_MM_DD_ISO_8601;

        return (empty($this->payee_date)) ? null : $this->payee_date->format($format);
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
            'payee_type'    => PayeeTypes::getAll(),
            'payee_country' => Country::getList()
        ];
        $this->requiredFieldValues = Common::createArrayObject($requiredFieldValues);

        $requiredFieldsConditional       = [
            'payee_type' => [
                PayeeTypes::COMPANY => [
                    'payee_registration_number',
                ],
            ],
        ];
        $this->requiredFieldsConditional = CommonUtils::createArrayObject($requiredFieldsConditional);
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
                'type'                => $this->payee_type,
                'name'                => $this->payee_name,
                'country'             => $this->payee_country,
                'date'                => $this->getPayeeDate(),
                'notification_url'    => $this->payee_notification_url,
                'registration_number' => $this->payee_registration_number,
                'address'             => $this->getAddressAttributesStructure()
            ]
        ];
    }
}
