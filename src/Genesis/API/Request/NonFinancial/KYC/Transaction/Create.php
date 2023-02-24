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

namespace Genesis\API\Request\NonFinancial\KYC\Transaction;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Constants\NonFinancial\KYC\DeviceFingerprintTypes;
use Genesis\API\Constants\NonFinancial\KYC\IndustryTypes;
use Genesis\API\Constants\NonFinancial\KYC\PaymentMethods;
use Genesis\API\Request\Base\NonFinancial\KYC\BaseRequest;
use Genesis\API\Traits\Request\NonFinancial\CustomerInformation;
use Genesis\API\Traits\Request\NonFinancial\DepositLimits;
use Genesis\API\Traits\Request\NonFinancial\KycBillingInformation;
use Genesis\API\Traits\Request\NonFinancial\KycShippingInformation;
use Genesis\API\Traits\Request\NonFinancial\PaymentDetails;
use Genesis\API\Traits\RestrictedSetter;
use Genesis\Exceptions\InvalidArgument;

/**
 * Class Create
 *
 * Implement this to scrub a new transaction. We will take the information specific to that transaction and
 * run various verification checks available, returning the recommendation, score, and third-party
 * verification scrubbing results.
 *
 * @package Genesis\API\Request\NonFinancial\KYC\Transaction
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class Create extends BaseRequest
{
    use RestrictedSetter, CustomerInformation, DepositLimits, KycBillingInformation,
        KycShippingInformation, PaymentDetails;

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
     * Customer loyalty level; for example: VIP; Bronze; Platinum; Gold; etc. This is an open text variable
     *
     * @var string
     */
    protected $customer_loyalty_level;

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
     * Empty if first deposit yyyy-mm-dd
     *
     * @var \DateTime
     */
    protected $first_deposit_date;

    /**
     * Empty if 0 withdrawals yyyy-mm-dd
     *
     * @var \DateTime
     */
    protected $first_withdrawal_date;

    /**
     * @var string
     */
    protected $deposits_count;

    /**
     * @var string
     */
    protected $withdrawals_count;

    /**
     * @var string
     */
    protected $current_balance;

    /**
     * Transaction id
     *
     * @var string
     */
    protected $transaction_unique_id;

    /**
     * Amount of transaction in minor currency unit, see Currency and Amount Handling for details
     *
     * @var string
     */
    protected $amount;

    /**
     * ISO 4217 Three digits
     *
     * @var string
     */
    protected $currency;

    /**
     * Represents the time of the transaction on the Merchant server. Format: yyyy-mm-dd hh:mm:ss
     *
     * @var \DateTime
     */
    protected $transaction_created_at;

    /**
     * Transaction status; it is recommended to send 0 on the initial call. Afterwards call Update
     * Transaction endpoint to update the status. 0 - numberUndefined; 1 - number- Approved; 2 - number- Pre-Auth;
     * 3 - number- Settled; 4 - number- Void;
     * 5 - number- Rejected internally by Negative Database or other scrubber decided to reject the transaction;
     * 6 - number- Declined the bank / gateway / processor rejected the transaction;
     * 7 - number- Chargeback; 8 - number- Return;9 - number- Pending; 10 - number- Pass Transaction validation;
     * 11 - number- Failed Transaction validation; 12 - number- efund; 13 - number- Approved Review;
     * 14 - number- Abandon This status is used when the user just leaves the transaction;
     *
     * @var string
     */
    protected $transaction_status;

    /**
     * Customers IP address
     *
     * @var string
     */
    protected $customer_ip_address;

    /**
     * Propietary DeviceId technology, refer to the DeviceId Instruction Manual (provided on request)
     *
     * @var string
     */
    protected $customer_device_id;

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
     * Represents the quantity of items in the shopping cart
     *
     * @var string
     */
    protected $shopping_cart_items_count;

    /**
     * Represents the local time of the customer doing the transaction. Format: yyyy-mm-dd hh:mm:ss
     *
     * @var \DateTime
     */
    protected $local_time;

    /**
     * internet; mobile; inhouse
     *
     * @var string
     */
    protected $order_source;

    /**
     * Open text variable; it represents the website name or URL that submitted the transaction
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
     * Open text variable; it represents the customers password in hashed format (using MD5) some
     * companies share that information in order to look for patterns
     *
     * @var string
     */
    protected $customer_password;

    /**
     * Number assigned to a given rule context. Please contact to get the available contexts.
     *
     * @var string
     */
    protected $rule_context;

    /**
     * Represents anything the merchant wants to store with this transaction
     *
     * @var string
     */
    protected $custom_variable;

    /**
     * Create constructor.
     */
    public function __construct()
    {
        parent::__construct('create_transaction');
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
            DeviceFingerprintTypes::getAll(),
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
    public function setIndustryType($type)
    {
        return $this->allowedOptionsSetter(
            'industry_type',
            IndustryTypes::getAll(),
            $type,
            'Invalid industry type.'
        );
    }

    /**
     * @param string $dateTime
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setTransactionCreatedAt($dateTime)
    {
        if (empty($dateTime)) {
            $this->transaction_created_at = null;

            return $this;
        }

        return $this->parseDate(
            'transaction_created_at',
            DateTimeFormat::getDateTimeFormats(),
            $dateTime,
            'Invalid value given for transaction_created_at.'
        );
    }

    /**
     * @return string|null
     */
    public function getTransactionCreatedAt()
    {
        return (empty($this->transaction_created_at)) ? null :
            $this->transaction_created_at->format(DateTimeFormat::YYYY_MM_DD_H_I_S);
    }

    /**
     * @param string $dateTime
     * @return $this
     * @throws InvalidArgument
     */
    public function setLocalTime($dateTime)
    {
        if (empty($dateTime)) {
            $this->local_time = null;

            return $this;
        }

        return $this->parseDate(
            'local_time',
            DateTimeFormat::getDateTimeFormats(),
            $dateTime,
            'Invalid value given for local_time.'
        );
    }

    /**
     * @return string
     */
    public function getLocalTime()
    {
        return (empty($this->local_time)) ? null :
            $this->local_time->format(DateTimeFormat::YYYY_MM_DD_H_I_S);
    }

    /**
     * @param string $date
     * @return $this|Create
     * @throws InvalidArgument
     */
    public function setCustomerRegistrationDate($date)
    {
        if (empty($date)) {
            $this->customer_registration_date = null;

            return $this;
        }

        return $this->parseDate(
            'customer_registration_date',
            DateTimeFormat::getAll(),
            $date,
            'Invalid value given for customer_registration_date'
        );
    }

    /**
     * @return string
     */
    public function getCustomerRegistrationDate()
    {
        return (empty($this->customer_registration_date)) ? null :
            $this->customer_registration_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * @param string $date
     * @return $this
     * @throws InvalidArgument
     */
    public function setFirstDepositDate($date)
    {
        if (empty($date)) {
            $this->first_deposit_date = null;

            return $this;
        }

        return $this->parseDate(
            'first_deposit_date',
            DateTimeFormat::getAll(),
            $date,
            'Invalid value given for first_deposit_date'
        );
    }

    /**
     * @return string|null
     */
    public function getFirstDepositDate()
    {
        return (empty($this->first_deposit_date)) ? null :
            $this->first_deposit_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * @param string $date
     * @return $this
     * @throws InvalidArgument
     */
    public function setFirstWithdrawalDate($date)
    {
        if (empty($date)) {
            $this->first_withdrawal_date = null;

            return $this;
        }

        return $this->parseDate(
            'first_withdrawal_date',
            DateTimeFormat::getAll(),
            $date,
            'Invalid value given for first_withdrawal_date'
        );
    }

    /**
     * @return string|null
     */
    public function getFirstWithdrawalDate()
    {
        return (empty($this->first_withdrawal_date)) ? null :
            $this->first_withdrawal_date->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_unique_id',
            'transaction_created_at',
            'customer_ip_address',
            'payment_method'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldsConditional = [
            'payment_method' => [
                PaymentMethods::CREDIT_CARD => [
                    'bin',
                    'tail',
                    'hashed_pan'
                ],
                PaymentMethods::ECHECK      => [
                    'routing',
                    'account'
                ],
                PaymentMethods::EWALLET     => [
                    'ewallet_id'
                ]
            ]
        ];

        $this->requiredFieldsConditional = \Genesis\Utils\Common::createArrayObject($requiredFieldsConditional);
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'session_id'                       => $this->session_id,
            'customer_username'                => $this->customer_username,
            'customer_unique_id'               => $this->customer_unique_id,
            'customer_loyalty_level'           => $this->customer_loyalty_level,
            'customer_registration_date'       => $this->getCustomerRegistrationDate(),
            'customer_registration_ip_address' => $this->customer_registration_ip_address,
            'customer_registration_device_id'  => $this->customer_registration_device_id,
            'first_deposit_date'               => $this->getFirstDepositDate(),
            'first_withdrawal_date'            => $this->getFirstWithdrawalDate(),
            'deposits_count'                   => $this->deposits_count,
            'withdrawals_count'                => $this->withdrawals_count,
            'current_balance'                  => $this->current_balance,
            'transaction_unique_id'            => $this->transaction_unique_id,
            'customer_information'             => $this->getCustomerInformationStructure(),
            'deposit_limits'                   => $this->getDepositLimitsStructure(),
            'billing_information'              => $this->getKycBillingStructure(),
            'shipping_information'             => $this->getKycShippingStructure(),
            'payment_details'                  => $this->getPaymentDetailsStructure(),
            'amount'                           => intval($this->transformAmount($this->amount, $this->currency)),
            'currency'                         => $this->currency,
            'transaction_created_at'           => $this->getTransactionCreatedAt(),
            'transaction_status'               => $this->transaction_status,
            'customer_ip_address'              => $this->customer_ip_address,
            'customer_device_id'               => $this->customer_device_id,
            'third_party_device_id'            => $this->third_party_device_id,
            'device_fingerprint'               => $this->device_fingerprint,
            'device_fingerprint_type'          => $this->device_fingerprint_type,
            'shopping_cart_items_count'        => $this->shopping_cart_items_count,
            'local_time'                       => $this->getLocalTime(),
            'order_source'                     => $this->order_source,
            'merchant_website'                 => $this->merchant_website,
            'industry_type'                    => $this->industry_type,
            'customer_password'                => $this->customer_password,
            'rule_context'                     => $this->rule_context,
            'custom_variable'                  => $this->custom_variable
        ];
    }
}
