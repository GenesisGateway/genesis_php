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

namespace Genesis\API\Traits\Request\NonFinancial;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Request\Base\NonFinancial\KYC\BaseRequest;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait KycBillingInformation
 * @package Genesis\API\Traits\Request\NonFinancial
 */
trait KycBillingInformation
{
    /**
     * @var string
     */
    protected $kyc_billing_first_name;

    /**
     * @var string
     */
    protected $kyc_billing_last_name;

    /**
     * @var string
     */
    protected $kyc_billing_customer_email;

    /**
     * @var string
     */
    protected $kyc_billing_address1;

    /**
     * @var string
     */
    protected $kyc_billing_address2;

    /**
     * @var string
     */
    protected $kyc_billing_city;

    /**
     * @var string
     */
    protected $kyc_billing_zip_code;

    /**
     * two-letter iso codes
     *
     * @var string
     */
    protected $kyc_billing_country;

    /**
     * @var string
     */
    protected $kyc_billing_province;

    /**
     * @var string
     */
    protected $kyc_billing_phone1;

    /**
     * Required for Visa only when MCC is a Financial Services one (e.g. MCC 6012)
     *
     * @var \DateTime
     */
    protected $kyc_billing_birth_date;

    /**
     * F - female; M - male
     *
     * @var string
     */
    protected $kyc_billing_gender;

    /**
     * @param $gender
     *
     * @return KycBillingInformation
     * @throws InvalidArgument
     */
    public function setKycBillingGender($gender)
    {
        return $this->allowedOptionsSetter(
            'kyc_billing_gender',
            [
                BaseRequest::GENDER_MALE,
                BaseRequest::GENDER_FEMALE
            ],
            $gender,
            'Invalid gender provided.'
        );
    }

    /**
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setKycBillingBirthDate($value)
    {
        if (empty($value)) {
            $this->kyc_billing_birth_date = null;

            return $this;
        }

        return $this->parseDate(
            'kyc_billing_birth_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid value given for kyc_billing_birth_date.'
        );
    }

    /**
     * @return string|null
     */
    public function getKycBillingBirthDate()
    {
        return (empty($this->kyc_billing_birth_date)) ? null :
            $this->kyc_billing_birth_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @return array
     */
    public function getKycBillingStructure()
    {
        return [
            'first_name'     => $this->kyc_billing_first_name,
            'last_name'      => $this->kyc_billing_last_name,
            'customer_email' => $this->kyc_billing_customer_email,
            'address1'       => $this->kyc_billing_address1,
            'address2'       => $this->kyc_billing_address2,
            'city'           => $this->kyc_billing_city,
            'zip_code'       => $this->kyc_billing_zip_code,
            'country'        => $this->kyc_billing_country,
            'province'       => $this->kyc_billing_province,
            'phone1'         => $this->kyc_billing_phone1,
            'birth_date'     => $this->getKycBillingBirthDate(),
            'gender'         => $this->kyc_billing_gender
        ];
    }
}
