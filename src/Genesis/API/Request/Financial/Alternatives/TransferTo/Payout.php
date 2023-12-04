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

namespace Genesis\API\Request\Financial\Alternatives\TransferTo;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Constants\Transaction\Parameters\Alternatives\AccountTypes;
use Genesis\API\Constants\Transaction\Parameters\IdentificationTypes;
use Genesis\API\Constants\Transaction\Parameters\Alternatives\PurposeOfRemittances;
use Genesis\API\Constants\Transaction\Types;
use Genesis\API\Request\Base\Financial;
use Genesis\API\Traits\Request\CustomerAddress\BillingInfoAttributes;
use Genesis\API\Traits\Request\CustomerAddress\ShippingInfoAttributes;
use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common;

/**
 * APM TransferTo Payout
 *
 * Provides payment services:
 *  BanAccount
 *  MobileWallet
 *  CashPickup
 *
 * Class Payout
 * @package Genesis\API\Request\Financial\Alternatives\TransferTo
 *
 * @codingStandardsIgnoreStart
 * @method string getCustomerEmail()                            Must contain valid e-mail of customer
 * @method string getPayerId()                                  ID of the Payer used to deliver the money through one of the 3 services
 * @method $this  setPayerId($value)                            ID of the Payer used to deliver the money through one of the 3 services
 * @method string getBankAccountNumber()                        Bank identification number of the customer
 * @method $this  setBankAccountNumber($value)                  Bank identification number of the customer
 * @method string getIndianFinancialSystemCode()                Bank code of the bank in which the consumer resides
 * @method string setIndianFinancialSystemCode()                Bank code of the bank in which the consumer resides
 * @method string getMsisdn()                                   Number uniquely identifying a subscription in a Global System
 * @method string getBranchNumber()                             Branch number
 * @method $this  setBranchNumber($value)                       Branch number
 * @method string getAccountType()                              Account type
 * @method string getRegisteredName()                           Registered name of the business
 * @method $this  setRegisteredName($value)                     Registered name of the business
 * @method string getRegistrationNumber()                       Registration number
 * @method $this  setRegistrationNumber($value)                 Registration number
 * @method string getDocumentReferenceNumber()                  Reference number for the contract
 * @method $this  setDocumentReferenceNumber($value)            Reference number for the contract
 * @method string getPurposeOfRemittance()                      Identification type
 * @method string getIban()                                     Bank account number in IBAN format
 * @method $this  setIban($value)                               Bank account number in IBAN format
 * @method string getIdNumber()                                 Identification number
 * @method $this  setIdNumber($value)                           Identification number
 * @method string getSenderLastName()                           Last name of the sender
 * @method $this  setSenderLastName($value)                     Last name of the sender
 * @method string getSenderFirstName()                          First name of the sender
 * @method $this  setSenderFirstName($value)                    First name of the sender
 * @method string getSenderCountryIsoCode()                     Three-letter country code of the sender
 * @method $this  setSenderCountryIsoCode($value)               Three-letter country code of the sender
 * @method string getSenderIdNumber()                           Identification number of the sender
 * @method $this  setSenderIdNumber($value)                     Identification number of the sender
 * @method string getSenderNationalityCountryIsoCode()          Three-letter country code corresponding to the nationality of the sender
 * @method $this  setSenderNationalityCountryIsoCode($value)    Three-letter country code corresponding to the nationality of the sender
 * @method string getSenderAddress()                            First line of address of the sender
 * @method $this  setSenderAddress($value)                      First line of address of the sender
 * @method string getSenderOccupation()                         Occupation of the sender
 * @method $this  setSenderOccupation($value)                   Occupation of the sender
 * @method string getSenderBeneficiaryRelationship()            Relationship between the sender and the beneficiary
 * @method $this  setSenderBeneficiaryRelationship($value)      Relationship between the sender and the beneficiary
 * @method string getSenderPostalCode()                         Postal code of the sender
 * @method $this  setSenderPostalCode($value)                   Postal code of the sender
 * @method string getSenderCity()                               City of the sender
 * @method $this  setSenderCity($value)                         City of the sender
 * @method string getSenderMsisdn()                             Phone number for payment to bank account and wallet registration number for payment to wallet
 * @method string getSenderGender()                             Gender of the sender
 * @method $this  setSenderGender($value)                       Gender of the sender
 * @method string getSenderIdType()                             Identification type of the sender
 * @method string getSenderProvinceState()                      Province State of the sender
 * @method $this  setSenderProvinceState($value)                Province State of the sender
 * @method string getSenderSourceOfFunds()                      Source of funds of the sender
 * @method $this  setSenderSourceOfFunds($value)                Source of funds of the sender
 * @method string getSenderCountryOfBirthIsoCode()              Three-letter country code corresponding to the country of birth of the sender
 * @method $this  setSenderCountryOfBirthIsoCode($value)        Three-letter country code corresponding to the country of birth of the sender
 * @codingStandardsIgnoreEnd
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Payout extends Financial
{
    use AsyncAttributes, PaymentAttributes, BillingInfoAttributes, ShippingInfoAttributes;

    /**
     * Sender MSISDN Min & Max string Length
     */
    const MIN_MSISDN_LENGTH = 6;
    const MAX_MSISDN_LENGTH = 32;

    /**
     * Must contain valid e-mail of customer
     *
     * @var string $customer_email
     */
    protected $customer_email;

    /**
     * ID of the Payer used to deliver the money through one of the 3 services
     *
     * @var string $payer_id
     */
    protected $payer_id;

    /**
     * Bank identification number of the customer. *Requirement based on the Payer
     *
     * @var string $bank_account_number
     */
    protected $bank_account_number;

    /**
     * Alias of the indian_financial_system_code
     *
     * @var string $ifs_code
     * @deprecated
     */
    protected $ifs_code;

    /**
     * Bank code of the bank in which the consumer resides. *Requirement based on the Payer
     *
     * @var string $indian_financial_system_code
     */
    protected $indian_financial_system_code;

    /**
     * Number uniquely identifying a subscription in a Global System. Requirement based on the Payer
     * in 6 and max 32 digits.
     *
     * @var string $msisdn
     */
    protected $msisdn;

    /**
     * Branch number. *Requirement based on the Payer
     *
     * @var string $branch_number
     */
    protected $branch_number;

    /**
     * Account type. *Requirement based on the Payer
     *
     * @var string $account_type
     */
    protected $account_type;

    /**
     * Registered name of the business. *Requirement based on the Payer
     *
     * @var string $registered_name
     */
    protected $registered_name;

    /**
     * Registration number. *Requirement based on the Payer
     *
     * @var string $registration_number
     */
    protected $registration_number;

    /**
     * Reference number for the contract. Requirement only for Business-to-Business (B2B) workflow
     *
     * @var string $document_reference_number
     */
    protected $document_reference_number;

    /**
     * Identification type. Requirement only for Business-to-Business (B2B) workflow
     *
     * @var string $purpose_of_remittance
     */
    protected $purpose_of_remittance;

    /**
     * Bank account number in IBAN format. *Requirement based on the Payer
     *
     * @var string $iban
     */
    protected $iban;

    /**
     * Identification type
     *
     * @var string $id_type
     */
    protected $id_type;

    /**
     * Identification number. *Requirement based on the Payer
     *
     * @var string $id_number
     */
    protected $id_number;

    /**
     * Date of birth with the following format YYYY-MM-DD. *Requirement based on the Payer
     *
     * @var \DateTime $sender_date_of_birth
     */
    protected $sender_date_of_birth;

    /**
     * Last name of the sender. Requirement based on the Payer
     *
     * @var string $sender_last_name
     */
    protected $sender_last_name;

    /**
     * First name of the sender. Requirement based on the Payer
     *
     * @var string $sender_first_name
     */
    protected $sender_first_name;

    /**
     * Three-letter country code of the sender. Requirement based on the Payer
     *
     * @var string $sender_country_iso_code
     */
    protected $sender_country_iso_code;

    /**
     * Identification number of the sender. Requirement based on the Payer
     *
     * @var string $sender_id_number
     */
    protected $sender_id_number;

    /**
     * Three-letter country code corresponding to the nationality of the sender. Requirement based on the Payer
     *
     * @var string $sender_nationality_country_iso_code
     */
    protected $sender_nationality_country_iso_code;

    /**
     * First line of address of the sender. Requirement based on the Payer
     *
     * @var string $sender_address
     */
    protected $sender_address;

    /**
     * Occupation of the sender. Requirement based on the Payer
     *
     * @var string $sender_occupation
     */
    protected $sender_occupation;

    /**
     * Relationship between the sender and the beneficiary. Requirement based on the Payer
     *
     * @var string $sender_beneficiary_relationship
     */
    protected $sender_beneficiary_relationship;

    /**
     * Postal code of the sender. Requirement based on the Payer
     *
     * @var string $sender_postal_code
     */
    protected $sender_postal_code;

    /**
     * City of the sender. Requirement based on the Payer
     *
     * @var string $sender_city
     */
    protected $sender_city;

    /**
     * Phone number for payment to bank account and wallet registration number for payment to wallet.
     * Min 6 and max 32 digits.
     *
     * @var string $sender_msisdn
     */
    protected $sender_msisdn;

    /**
     * Gender of the sender. Requirement based on the Payer
     *
     * @var string $sender_gender
     */
    protected $sender_gender;

    /**
     * Identification type of the sender. Requirement based on the Payer
     *
     * @var string $sender_id_type
     */
    protected $sender_id_type;

    /**
     * Province State of the sender. Requirement based on the Payer
     *
     * @var string $sender_province_state
     */
    protected $sender_province_state;

    /**
     * Source of funds of the sender. Requirement based on the Payer
     *
     * @var string $sender_source_of_funds
     */
    protected $sender_source_of_funds;

    /**
     * Three-letter country code corresponding to the country of birth of the sender. Requirement based on the Payer
     *
     * @var string $sender_country_of_birth_iso_code
     */
    protected $sender_country_of_birth_iso_code;

    /**
     * Returns the Request transaction type
     *
     * @return string
     */
    protected function getTransactionType()
    {
        return Types::TRANSFER_TO_PAYOUT;
    }

    /**
     * Must contain valid e-mail of customer
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setCustomerEmail($value)
    {
        $customerEmail = trim($value);

        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgument(
                'Please, enter a valid Customer Email'
            );
        }

        $this->customer_email = $customerEmail;

        return $this;
    }

    /**
     * Alias of the indian_financial_system_code
     *
     * @return string
     * @deprecated Deprecated since 1.18.7. getIndianFinancialSystemCode() should used directly
     */
    public function getIfsCode()
    {
        return $this->indian_financial_system_code;
    }

    /**
     * Alias of the indian_financial_system_code
     *
     * @param string $value
     * @return $this
     * @deprecated Deprecated since 1.18.7. setIndianFinancialSystemCode() should used directly
     */
    public function setIfsCode($value)
    {
        $this->indian_financial_system_code = $value;

        return $this;
    }

    /**
     * Number uniquely identifying a subscription in a Global System
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setMsisdn($value)
    {
        if (empty($value)) {
            $this->msisdn = null;

            return $this;
        }

        return $this->setLimitedString(
            'msisdn',
            $value,
            self::MIN_MSISDN_LENGTH,
            self::MAX_MSISDN_LENGTH
        );
    }

    /**
     * Account type. *Requirement based on the Payer
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setAccountType($value)
    {
        if (empty($value)) {
            $this->account_type = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'account_type',
            AccountTypes::getAll(),
            $value,
            'Invalid value given for Account Type.'
        );
    }

    /**
     * Identification type
     *
     * @param $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setIdType($value)
    {
        if (empty($value)) {
            $this->id_type = null;

            return $this;
        }

        $this->allowedOptionsSetter(
            'id_type',
            IdentificationTypes::getAll(),
            $value,
            'Invalid value for id_type.'
        );

        return $this;
    }

    /**
     * Purpose of Remittance Type
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setPurposeOfRemittance($value)
    {
        if (empty($value)) {
            $this->purpose_of_remittance = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'purpose_of_remittance',
            PurposeOfRemittances::getAll(),
            $value,
            'Invalid value given for Purpose of Remittance.'
        );
    }

    /**
     * Date of birth with the following format YYYY-MM-DD. *Requirement based on the Payer
     *
     * @return string
     */
    public function getSenderDateOfBirth()
    {
        if (empty($this->sender_date_of_birth)) {
            return null;
        }

        return $this->sender_date_of_birth->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
    }

    /**
     * Date of birth with the following format YYYY-MM-DD. *Requirement based on the Payer
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setSenderDateOfBirth($value)
    {
        if (empty($value)) {
            $this->sender_date_of_birth = null;

            return $this;
        }

        return $this->parseDate(
            'sender_date_of_birth',
            DateTimeFormat::getAll(),
            $value,
            'Invalid birth date format.'
        );
    }

    /**
     * Phone number for payment to bank account and wallet registration number for payment to wallet.
     * Min 6 and max 32 digits. Numeric values only (can contain “+” at start or “(“ , ”)” , ”-“).
     * Requirement based on the Payer
     *
     * @param string $value
     * @return Payout
     * @throws InvalidArgument
     */
    public function setSenderMsisdn($value)
    {
        if (empty($value)) {
            $this->sender_msisdn = null;

            return $this;
        }

        return $this->setLimitedString(
            'sender_msisdn',
            $value,
            self::MIN_MSISDN_LENGTH,
            self::MAX_MSISDN_LENGTH
        );
    }

    /**
     * Sender Identification type
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setSenderIdType($value)
    {
        if (empty($value)) {
            $this->sender_id_type = null;

            return $this;
        }

        $this->allowedOptionsSetter(
            'sender_id_type',
            IdentificationTypes::getAll(),
            $value,
            'Invalid Sender Identification Type value'
        );

        return $this;
    }


    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_id',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'payer_id'
        ];

        $this->requiredFields = Common::createArrayObject($requiredFields);

        $requiredFieldsValues = [
            'currency' => ['EUR', 'GBP', 'HKD', 'USD']
        ];

        $this->requiredFieldValues = Common::createArrayObject($requiredFieldsValues);
    }

    protected function getPaymentTransactionStructure()
    {
        return [
            'return_success_url'                  => $this->return_success_url,
            'return_failure_url'                  => $this->return_failure_url,
            'amount'                              => $this->transformAmount($this->amount, $this->currency),
            'currency'                            => $this->currency,
            'customer_email'                      => $this->customer_email,
            'payer_id'                            => $this->payer_id,
            'bank_account_number'                 => $this->bank_account_number,
            'indian_financial_system_code'        => $this->indian_financial_system_code,
            'msisdn'                              => $this->msisdn,
            'branch_number'                       => $this->branch_number,
            'account_type'                        => $this->account_type,
            'registered_name'                     => $this->registered_name,
            'registration_number'                 => $this->registration_number,
            'document_reference_number'           => $this->document_reference_number,
            'purpose_of_remittance'               => $this->purpose_of_remittance,
            'iban'                                => $this->iban,
            'id_type'                             => $this->id_type,
            'id_number'                           => $this->id_number,
            'sender_date_of_birth'                => $this->getSenderDateOfBirth(),
            'sender_last_name'                    => $this->sender_last_name,
            'sender_first_name'                   => $this->sender_first_name,
            'sender_country_iso_code'             => $this->sender_country_iso_code,
            'sender_id_number'                    => $this->sender_id_number,
            'sender_nationality_country_iso_code' => $this->sender_nationality_country_iso_code,
            'sender_address'                      => $this->sender_address,
            'sender_occupation'                   => $this->sender_occupation,
            'sender_beneficiary_relationship'     => $this->sender_beneficiary_relationship,
            'sender_postal_code'                  => $this->sender_postal_code,
            'sender_city'                         => $this->sender_city,
            'sender_msisdn'                       => $this->sender_msisdn,
            'sender_gender'                       => $this->sender_gender,
            'sender_id_type'                      => $this->sender_id_type,
            'sender_province_state'               => $this->sender_province_state,
            'sender_source_of_funds'              => $this->sender_source_of_funds,
            'sender_country_of_birth_iso_code'    => $this->sender_country_of_birth_iso_code,
            'billing_address'                     => $this->getBillingAddressParamsStructure(),
            'shipping_address'                    => $this->getShippingAddressParamsStructure()
        ];
    }
}
