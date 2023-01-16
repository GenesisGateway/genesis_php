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
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Traits\Request\Payout;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Constants\Transaction\Parameters\Payout\MoneyTransferTypes;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait MoneyTransferPayoutAttributes
 * @package Genesis\API\Traits\Request\Payout
 *
 * @method string getMoneyTransferType()
 * @method string getMoneyTransferSenderAccountNumber()
 * @method string getMoneyTransferSenderFirstName()
 * @method string getMoneyTransferSenderLastName()
 * @method string getMoneyTransferSenderCountry()
 * @method string getMoneyTransferSenderCity()
 * @method string getMoneyTransferSenderZipCode()
 * @method string getMoneyTransferSenderAddress1()
 * @method string getMoneyTransferSenderState()
 *
 * @method $this setMoneyTransferSenderFirstName($value)
 * @method $this setMoneyTransferSenderLastName($value)
 * @method $this setMoneyTransferSenderCountry($value)
 * @method $this setMoneyTransferSenderCity($value)
 * @method $this setMoneyTransferSenderZipCode($value)
 * @method $this setMoneyTransferSenderAddress1($value)
 * @method $this setMoneyTransferSenderState($value)
 *
 */
trait MoneyTransferPayoutAttributes
{
    /**
     * The type of money transfer. It can be account_to_account, person_to_person, wallet_transfer, funds_transfer
     * @var string $money_transfer_type
     */
    protected $money_transfer_type;

    /**
     * Sender account number
     * @var string $money_transfer_sender_account_number
     */
    protected $money_transfer_sender_account_number;

    /**
     * Must contain valid birth date of the sender.
     * @var \DateTime $money_transfer_sender_birth_date
     */
    protected $money_transfer_sender_birth_date;

    /**
     * Must contain a valid Service Provider Name. Only alphanumeric characters are allowed (including spaces).
     * @var string $money_transfer_service_provider_name
     */
    protected $money_transfer_service_provider_name;

    /**
     * Sender first name
     * @var string $money_transfer_sender_first_name
     */
    protected $money_transfer_sender_first_name;

    /**
     * Sender last name
     * @var string $money_transfer_sender_last_name
     */
    protected $money_transfer_sender_last_name;

    /**
     * Sender Country code in ISO 3166
     * @var string $money_transfer_sender_country
     */
    protected $money_transfer_sender_country;

    /**
     * Sender City
     * @var string $money_transfer_sender_city
     */
    protected $money_transfer_sender_city;

    /**
     * Sender ZIP code
     * @var string $money_transfer_sender_zip_code
     */
    protected $money_transfer_sender_zip_code;

    /**
     * Sender Primary address
     * @var string $money_transfer_sender_address1
     */
    protected $money_transfer_sender_address1;

    /**
     * Sender State code in ISO 3166-2, required for USA and Canada
     * @var string $money_transfer_sender_state
     */
    protected $money_transfer_sender_state;

    /**
     * @param string $value
     * @throws InvalidArgument
     */
    public function setMoneyTransferType($value)
    {
        if ($value === null) {
            $this->money_transfer_type = null;

            return $this;
        }

        $this->allowedOptionsSetter(
            'money_transfer_type',
            MoneyTransferTypes::getAllowedMoneyTransferTypes(),
            $value,
            'Invalid value for type parameter.'
        );

        return $this;
    }

    /**
     * Accept any of supported formats for birthdate
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setMoneyTransferSenderBirthDate($value)
    {
        if (empty($value)) {
            $this->money_transfer_sender_birth_date = null;

            return $this;
        }

        return $this->parseDate(
            'money_transfer_sender_birth_date',
            DateTimeFormat::getAll(),
            $value,
            'Invalid value given for Birth Date.'
        );
    }

    /**
     * Format BirtDate accordingly
     * @return string|null
     */
    public function getMoneyTransferSenderBirthDate()
    {
        return (empty($this->money_transfer_sender_birth_date)) ? null :
            $this->money_transfer_sender_birth_date->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);
    }

    /**
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setMoneyTransferSenderAccountNumber($value)
    {
        return $this->setLimitedString(
            'money_transfer_sender_account_number',
            $value,
            null,
            self::MONEY_TRANSFER_SENDER_ACCOUNT_NUMBER_MAX_LENGTH
        );
    }

    /**
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setMoneyTransferServiceProviderName($value)
    {
        return $this->setLimitedString(
            'money_transfer_service_provider_name',
            $value,
            null,
            self::MONEY_TRANSFER_SERVICE_PROVIDER_NAME_MAX_LENGTH
        );
    }

    /**
     * Return Money Transfer payout structure
     * @return array
     */
    protected function getMoneyTransferPayoutStructure()
    {
        return [
            'type'                  => $this->money_transfer_type,
            'sender_account_number' => $this->money_transfer_sender_account_number,
            'sender_birth_date'     => $this->getMoneyTransferSenderBirthDate(),
            'service_provider_name' => $this->money_transfer_service_provider_name,
            'sender_address'        => [
                'first_name' => $this->money_transfer_sender_first_name,
                'last_name'  => $this->money_transfer_sender_last_name,
                'country'    => $this->money_transfer_sender_country,
                'city'       => $this->money_transfer_sender_city,
                'zip_code'   => $this->money_transfer_sender_zip_code,
                'address1'   => $this->money_transfer_sender_address1,
                'state'      => $this->money_transfer_sender_state
            ]
        ];
    }

    /**
     * Attributes to check if Money Transfer Type is set
     * @return array
     */
    protected function requiredMoneyTransferFieldsConditional()
    {
        return [
            'money_transfer_type' => [
                'money_transfer_sender_account_number',
                'money_transfer_sender_first_name',
                'money_transfer_sender_last_name',
                'money_transfer_sender_country',
                'money_transfer_sender_city',
                'money_transfer_sender_zip_code',
                'money_transfer_sender_address1',
            ],
            'money_transfer_sender_country' => [
                'US' => ['money_transfer_sender_state'],
                'CA' => ['money_transfer_sender_state']
            ]
        ];
    }
}
