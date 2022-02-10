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

namespace Genesis\API\Request\NonFinancial\KYC\ConsumerRegistration;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Request\Base\NonFinancial\KYC\BaseRequest;
use Genesis\API\Traits\Request\NonFinancial\CustomerInformation;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class Create
 *
 * Review all aspects of the customer’s information, as it is received in the registration process,
 * against local and external databases to increase accuracy and produce a risk score for that customer.
 *
 * @package Genesis\API\Request\NonFinancial\KYC\ConsumerRegistration
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class Create extends BaseRequest
{
    use RestrictedSetter, CustomerInformation;

    /**
     * If this value is not provided the user email account should be complete and valid
     *
     * @var string
     */
    protected $session_id;

    /**
     * Username of the customer on your system
     *
     * @var string
     */
    protected $customer_username;

    /**
     * Unique user identificator on your system
     *
     * @var string
     */
    protected $customer_unique_id;

    /**
     * Date in which the customer was registered in the system OR the date
     * in which the customer was created in the cashier Database yyyy-mm-dd
     *
     * @var \DateTime
     */
    protected $customer_registration_date;

    /**
     * IP address of customer used when the customer was registered in the system OR the current IP address
     *
     * @var string
     */
    protected $customer_registration_ip_address;

    /**
     * Propietary DeviceId technology, refer to the DeviceId Instruction Manual (provided on request)
     *
     * @var string
     */
    protected $customer_registration_device_id;

    /**
     * Third Party DeviceId
     *
     * @var string
     */
    protected $third_party_device_id;

    /**
     * Open Source DeviceId technologies (Intepreted as a String)
     *
     * @var string
     */
    protected $device_fingerprint;

    /**
     * 1 - Custom; 2 - Open Source; 3 - Open Source 2;
     *
     * @var string
     */
    protected $device_fingerprint_type;

    /**
     * 1 - Registration;2 - Profile Update;
     *
     * @var string
     */
    protected $profile_action_type;

    /**
     * 0 - Undefined;1 - Review;2 - Denied;3 - Approved;
     *
     * @var string
     */
    protected $profile_current_status;

    /**
     * Open text variable. Represents the code entered by the customer
     *
     * @var string
     */
    protected $bonus_code;

    /**
     * optional
     *
     * @var \DateTime
     */
    protected $bonus_submission_date;

    /**
     * optional
     *
     * @var string
     */
    protected $bonus_amount;

    /**
     * optional
     *
     * @var string
     */
    protected $merchant_website;

    /**
     * 1 - Finance; 2 - Gambling; 3 - Crypto; 4 - Travel; 5 - Retail; 6 - Risk Vendor;
     * 7 - Adult; 8 - Remittance/Transfer; 9 - Other;
     *
     * @var string
     */
    protected $industry_type;

    /**
     * optional
     *
     * @var string
     */
    protected $how_did_you_hear;

    /**
     * optional
     *
     * @var string
     */
    protected $affiliate_id;

    /**
     * Number assigned to a given rule context. Please contact to get the available contexts
     *
     * @var string
     */
    protected $rule_context;

    /**
     * Create constructor.
     */
    public function __construct()
    {
        parent::__construct('create_consumer');
    }

    /**
     * @param $type
     *
     * @return Create
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setDeviceFingerprintType($type)
    {
        return $this->allowedOptionsSetter(
            'device_fingerprint_type',
            [
                self::DEVICE_FINGERPRINT_TYPE_CUSTOM,
                self::DEVICE_FINGERPRINT_TYPE_OPEN_SOURCE,
                self::DEVICE_FINGERPRINT_TYPE_OPEN_SOURCE2
            ],
            $type,
            'Invalid device fingerprint type.'
        );
    }

    /**
     * @param $type
     *
     * @return Create
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setProfileActionType($type)
    {
        return $this->allowedOptionsSetter(
            'profile_action_type',
            [
                self::PROFILE_ACTION_TYPE_REGISTRATION,
                self::PROFILE_ACTION_TYPE_PROFILE_UPDATE
            ],
            $type,
            'Invalid profile action type.'
        );
    }

    /**
     * @param $status
     *
     * @return Create
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setProfileCurrentStatus($status)
    {
        return $this->allowedOptionsSetter(
            'profile_current_status',
            [
                self::PROFILE_CURRENT_STATUS_UNDEFINED,
                self::PROFILE_CURRENT_STATUS_REVIEW,
                self::PROFILE_CURRENT_STATUS_DENIED,
                self::PROFILE_CURRENT_STATUS_APPROVED
            ],
            $status,
            'Invalid profile current status.'
        );
    }

    /**
     * @param $type
     *
     * @return Create
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setIndustryType($type)
    {
        return $this->allowedOptionsSetter(
            'industry_type',
            [
                self::INDUSTRY_TYPE_FINANCE,
                self::INDUSTRY_TYPE_GAMBLING,
                self::INDUSTRY_TYPE_CRYPTO,
                self::INDUSTRY_TYPE_TRAVEL,
                self::INDUSTRY_TYPE_RETAIL,
                self::INDUSTRY_TYPE_RISK_VENDOR,
                self::INDUSTRY_TYPE_ADULT,
                self::INDUSTRY_TYPE_REMITTANCE_TRANSFER,
                self::INDUSTRY_TYPE_OTHER
            ],
            $type,
            'Invalid industry type.'
        );
    }

    /**
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setCustomerRegistrationDate($value)
    {
        if (empty($value)) {
            $this->customer_registration_date = null;

            return $this;
        }

        return $this->parseDate(
            'customer_registration_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid value given for customer_registration_date.'
        );
    }

    /**
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBonusSubmissionDate($value)
    {
        if (empty($value)) {
            $this->bonus_submission_date = null;

            return $this;
        }

        return $this->parseDate(
            'bonus_submission_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid value given for bonus_submission_date.'
        );
    }

    /**
     * @return string|null
     */
    public function getBonusSubmissionDate()
    {
        return (empty($this->bonus_submission_date)) ? null :
            $this->bonus_submission_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    public function getCustomerRegistrationDate()
    {
        return (empty($this->customer_registration_date)) ? null :
            $this->customer_registration_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'customer_unique_id',
            'customer_registration_date',
            'customer_registration_ip_address',
            'first_name',
            'last_name',
            'customer_email',
            'address1',
            'city',
            'province',
            'zip_code',
            'country'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'session_id'                       => $this->session_id,
            'customer_information'             => $this->getCustomerInformationStructure(),
            'customer_username'                => $this->customer_username,
            'customer_unique_id'               => $this->customer_unique_id,
            'customer_registration_date'       => $this->getCustomerRegistrationDate(),
            'customer_registration_ip_address' => $this->customer_registration_ip_address,
            'customer_registration_device_id'  => $this->customer_registration_device_id,
            'third_party_device_id'            => $this->third_party_device_id,
            'device_fingerprint'               => $this->device_fingerprint,
            'device_fingerprint_type'          => $this->device_fingerprint_type,
            'profile_action_type'              => $this->profile_action_type,
            'profile_current_status'           => $this->profile_current_status,
            'bonus_code'                       => $this->bonus_code,
            'bonus_submission_date'            => $this->getBonusSubmissionDate(),
            'bonus_amount'                     => $this->bonus_amount,
            'merchant_website'                 => $this->merchant_website,
            'industry_type'                    => $this->industry_type,
            'how_did_you_hear'                 => $this->how_did_you_hear,
            'affiliate_id'                     => $this->affiliate_id,
            'rule_context'                     => $this->rule_context,
        ];
    }
}
