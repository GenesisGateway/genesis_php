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

namespace Genesis\Api\Request\NonFinancial\Alternatives\Alipay;

use Genesis\Api\Constants\NonFinancial\Alternatives\Alipay\MerchantTypes;
use Genesis\Api\Constants\NonFinancial\Alternatives\Alipay\SiteTypes;
use Genesis\Api\Request\Base\NonFinancial\Alternatives\Alipay\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\Alternatives\Alipay\SiteInformationAttributes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class RegisterMerchant
 *
 * Alipay APM Services - Register Merchant
 * Registers online-payment merchants into the Alipay system or updates their registration information
 *
 * @package Genesis\Api\Request\NonFinancial\Alternatives\Alipay
 *
 * @see \Genesis\Api\Constants\NonFinancial\Alternatives\Alipay\MerchantTypes
 *
 * @method string|null getMerchantType()
 * @method string|null getShareholderId()
 * @method string|null getShareholderName()
 * @method string|null getRegistrationNumber()
 * @method string|null getRepresentativeName()
 * @method string|null getRepresentativeId()
 * @method string|null getSettlementNumber()
 * @method string|null getContactNumber()
 * @method string|null getContactEmail()
 * @method string|null getCustomerServiceNumber()
 * @method string|null getCustomerServiceEmail()
 * @method $this setMerchantType($value)
 */
class RegisterMerchant extends BaseRequest
{
    use SiteInformationAttributes;

    /**
     * Max length for IDs, registration number and email fields
     */
    const LENGTH_128 = 128;

    /**
     * Max length for names, settlement number and phone number fields
     */
    const LENGTH_64 = 64;

    /**
     * Allowed characters for phone numbers: digits and +-()
     */
    const PATTERN_PHONE_NUMBER = '/^[0-9+\-()]+$/';

    /**
     * Allowed characters for the settlement number: ASCII letters and digits
     */
    const PATTERN_SETTLEMENT_NUMBER = '/^[a-zA-Z0-9]+$/';

    /**
     * Merchant type: INDIVIDUAL (sole proprietorship) or ENTERPRISE
     *
     * @var string|null
     */
    protected $merchant_type;

    /**
     * ID/passport number or business registration number of the primary shareholder (ENTERPRISE)
     *
     * @var string|null
     */
    protected $shareholder_id;

    /**
     * Legal name of the primary shareholder (ENTERPRISE)
     *
     * @var string|null
     */
    protected $shareholder_name;

    /**
     * Business registration number
     *
     * @var string|null
     */
    protected $registration_number;

    /**
     * Full legal name of the business owner (required for INDIVIDUAL)
     *
     * @var string|null
     */
    protected $representative_name;

    /**
     * ID or passport number of the business owner (required for INDIVIDUAL)
     *
     * @var string|null
     */
    protected $representative_id;

    /**
     * Settlement bank account number, letters and digits only
     *
     * @var string|null
     */
    protected $settlement_number;

    /**
     * Merchant contact phone number, digits and +-() only
     *
     * @var string|null
     */
    protected $contact_number;

    /**
     * Merchant contact email address
     *
     * @var string|null
     */
    protected $contact_email;

    /**
     * Customer service phone number, digits and +-() only
     *
     * @var string|null
     */
    protected $customer_service_number;

    /**
     * Customer service email address
     *
     * @var string|null
     */
    protected $customer_service_email;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct('register_merchant');
    }

    /**
     * Shareholder ID/passport or business registration number, max 128 characters
     *
     * @param string|null $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setShareholderId($value)
    {
        return $this->setLimitedString('shareholder_id', $this->nullIfEmpty($value), null, self::LENGTH_128);
    }

    /**
     * Shareholder legal name, max 64 characters
     *
     * @param string|null $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setShareholderName($value)
    {
        return $this->setLimitedString('shareholder_name', $this->nullIfEmpty($value), null, self::LENGTH_64);
    }

    /**
     * Business registration number, max 128 characters
     *
     * @param string|null $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setRegistrationNumber($value)
    {
        return $this->setLimitedString('registration_number', $this->nullIfEmpty($value), null, self::LENGTH_128);
    }

    /**
     * Business owner full legal name, max 64 characters
     *
     * @param string|null $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setRepresentativeName($value)
    {
        return $this->setLimitedString('representative_name', $this->nullIfEmpty($value), null, self::LENGTH_64);
    }

    /**
     * Business owner ID or passport number, max 128 characters
     *
     * @param string|null $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setRepresentativeId($value)
    {
        return $this->setLimitedString('representative_id', $this->nullIfEmpty($value), null, self::LENGTH_128);
    }

    /**
     * Settlement bank account number, ASCII letters and digits only, max 64 characters
     *
     * @param string|null $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setSettlementNumber($value)
    {
        return $this->setPatternString(
            'settlement_number',
            $value,
            self::PATTERN_SETTLEMENT_NUMBER,
            self::LENGTH_64
        );
    }

    /**
     * Merchant contact phone number, digits and +-() only, max 64 characters
     *
     * @param string|null $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setContactNumber($value)
    {
        return $this->setPatternString(
            'contact_number',
            $value,
            self::PATTERN_PHONE_NUMBER,
            self::LENGTH_64
        );
    }

    /**
     * Merchant contact email address, max 128 characters
     *
     * @param string|null $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setContactEmail($value)
    {
        return $this->setEmailAddress('contact_email', $value, self::LENGTH_128);
    }

    /**
     * Customer service phone number, digits and +-() only, max 64 characters
     *
     * @param string|null $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setCustomerServiceNumber($value)
    {
        return $this->setPatternString(
            'customer_service_number',
            $value,
            self::PATTERN_PHONE_NUMBER,
            self::LENGTH_64
        );
    }

    /**
     * Customer service email address, max 128 characters
     *
     * @param string|null $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setCustomerServiceEmail($value)
    {
        return $this->setEmailAddress('customer_service_email', $value, self::LENGTH_128);
    }

    /**
     * Set the required fields, allowed values and merchant type dependent fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'merchant_type',
            'site_information_type',
            'site_information_url',
            'contact_number',
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'merchant_type'         => MerchantTypes::getAll(),
            'site_information_type' => SiteTypes::getAll(),
        ];

        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);

        $requiredFieldsConditional = [
            'merchant_type' => [
                MerchantTypes::ENTERPRISE => ['shareholder_id', 'shareholder_name', 'registration_number'],
                MerchantTypes::INDIVIDUAL => ['representative_name', 'representative_id'],
            ],
        ];

        $this->requiredFieldsConditional = CommonUtils::createArrayObject($requiredFieldsConditional);
    }

    /**
     * Request body structure
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'merchant_type'           => $this->merchant_type,
            'site_information'        => $this->getSiteInformationStructure(),
            'shareholder_id'          => $this->shareholder_id,
            'shareholder_name'        => $this->shareholder_name,
            'registration_number'     => $this->registration_number,
            'representative_name'     => $this->representative_name,
            'representative_id'       => $this->representative_id,
            'settlement_number'       => $this->settlement_number,
            'contact_number'          => $this->contact_number,
            'contact_email'           => $this->contact_email,
            'customer_service_number' => $this->customer_service_number,
            'customer_service_email'  => $this->customer_service_email,
        ];
    }

    /**
     * Normalizes empty input to null, otherwise casts to string
     *
     * @param mixed $value
     *
     * @return string|null
     */
    private function nullIfEmpty($value)
    {
        return ($value === null || $value === '') ? null : (string) $value;
    }

    /**
     * Sets a length-limited string that must match the given pattern. Empty input clears the field.
     *
     * @param string      $field
     * @param string|null $value
     * @param string      $pattern
     * @param int         $maxLength
     *
     * @return $this
     * @throws InvalidArgument
     */
    private function setPatternString($field, $value, $pattern, $maxLength)
    {
        $value = $this->nullIfEmpty($value);

        if ($value !== null && !preg_match($pattern, $value)) {
            throw new InvalidArgument("Invalid value for $field. Allowed characters: $pattern");
        }

        return $this->setLimitedString($field, $value, null, $maxLength);
    }

    /**
     * Sets a length-limited email address. Empty input clears the field.
     *
     * @param string      $field
     * @param string|null $value
     * @param int         $maxLength
     *
     * @return $this
     * @throws InvalidArgument
     */
    private function setEmailAddress($field, $value, $maxLength)
    {
        $value = $this->nullIfEmpty($value);

        if ($value !== null && filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgument("Invalid value for $field. A valid email address is expected.");
        }

        return $this->setLimitedString($field, $value, null, $maxLength);
    }
}
