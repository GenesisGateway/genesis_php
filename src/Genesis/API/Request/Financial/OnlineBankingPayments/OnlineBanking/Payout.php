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

namespace Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking;

use Genesis\API\Constants\BankAccountTypes;
use Genesis\API\Constants\Transaction\Parameters\OnlineBanking\PayoutBankParameters;
use Genesis\API\Constants\Transaction\Parameters\OnlineBanking\PayoutPaymentTypesParameters;
use Genesis\API\Constants\Transaction\Parameters\OnlineBanking\PayoutBankCodeParameters;
use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\AsyncAttributes;
use Genesis\API\Traits\Request\Financial\BirthDateAttributes;
use Genesis\API\Traits\Request\Financial\NotificationAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\Financial\OnlineBankingPayments\CustomerAttributes;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Exceptions\InvalidClassMethod;
use Genesis\Utils\Common;

/**
 * Class Payout
 *
 * OnlineBanking Payout - oBeP-style alternative payment method
 *
 * @package Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking
 *
 * @method Payout setBankAccountName($value) Set Customer’s bank account name
 * @method Payout setBankAccountNumber($value) Set Customer’s bank account number
 * @method Payout setBankName($value) Set Customer’s bank name
 * @method Payout setBankCode($value) Set Customer’s bank code
 * @method Payout setBankBranch($value) Set Customer’s bank branch
 * @method Payout setBankProvince($value) Set Name of the province that the bank is located
 * @method string getPaymentType() Get Payment type
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class Payout extends \Genesis\API\Request\Base\Financial
{
    use AddressInfoAttributes, AsyncAttributes, PaymentAttributes,
        NotificationAttributes, BirthDateAttributes, CustomerAttributes;

    const ID_CARD_NUMBER_MAX_LENGTH          = 30;
    const PAYER_BANK_PHONE_NUMBER_MAX_LENGTH = 11;
    const DOCUMENT_TYPE_MAX_LENGTH           = 10;
    const ACCOUNT_ID_MAX_LENGTH              = 255;
    const USER_ID_MAX_LENGTH                 = 255;

    /**
     * Customer’s bank account name
     *
     * @var string
     */
    protected $bank_account_name;

    /**
     * Customer’s bank account number
     *
     * @var string
     */
    protected $bank_account_number;

    /**
     * Customer’s bank name
     *
     * @var string
     */
    protected $bank_name;

    /**
     * Customer’s bank code
     *
     * @var string
     */
    protected $bank_code;

    /**
     * Customer’s bank branch
     *
     * @var string
     */
    protected $bank_branch;

    /**
     * Returns the Request transaction type
     * @return string
     */

    /**
     * Name of the province that the bank is located
     *
     * @var string $bank_province
     */
    protected $bank_province;

    /**
     * ID card number
     *
     * @var string $id_card_number
     */
    protected $id_card_number;

    /**
     * Payer bank phone number
     *
     * @var string $payer_bank_phone_number
     */
    protected $payer_bank_phone_number;

    /**
     * The type of account.
     *     C: for Checking accounts
     *     S: for Savings accounts
     *     M: for Maestra accounts(Only Peru)
     *
     * @var string $bank_account_type
     */
    protected $bank_account_type;

    /**
     * ID card/document type
     *
     * @var string $document_type
     */
    protected $document_type;

    /**
     * Unique account identifier in Trustly's system
     * You will receive this after Select
     * Account call and after Trustly Sale on the notification URL
     *
     * @var string $account_id
     */
    protected $account_id;

    /**
     * Unique user identifier defined by merchant
     *
     * @var string $user_id
     */
    protected $user_id;

    /**
     * Verifier digit. Given by external provider, used to verify transaction
     *
     * @var string $bank_account_verification_digit
     */
    protected $bank_account_verification_digit;

    /**
     * Bank payout subtype.
     * Available values: bank_to_bank, pix, bsb, pay_id, bank_to_bank_b2b, pix_b2b
     *
     * @var string protected $payment_type;
     */
    protected $payment_type;

    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::ONLINE_BANKING_PAYOUT;
    }

    /**
     * ID card number
     *
     * @param $value
     * @return Payout
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setIdCardNumber($value)
    {
        return $this->setLimitedString(
            'id_card_number',
            $value,
            null,
            self::ID_CARD_NUMBER_MAX_LENGTH
        );
    }

    /**
     * Payer bank phone number
     *
     * @param $value
     * @return Payout
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setPayerBankPhoneNumber($value)
    {
        return $this->setLimitedString(
            'payer_bank_phone_number',
            $value,
            null,
            self::PAYER_BANK_PHONE_NUMBER_MAX_LENGTH
        );
    }

    /**
     * The type of account
     *
     * @param $value
     * @return Payout
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBankAccountType($value)
    {
        return $this->allowedOptionsSetter(
            'bank_account_type',
            BankAccountTypes::getAll(),
            $value,
            'Invalid bank_account_type.'
        );
    }

    /**
     * ID card/document type
     *
     * @param $value
     * @return Payout
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setDocumentType($value)
    {
        return $this->setLimitedString(
            'document_type',
            $value,
            null,
            self::DOCUMENT_TYPE_MAX_LENGTH
        );
    }

    /**
     * Unique account identifier in Trustly's system
     *
     * @param $value
     * @return Payout
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setAccountId($value)
    {
        return $this->setLimitedString(
            'account_id',
            $value,
            null,
            self::ACCOUNT_ID_MAX_LENGTH
        );
    }

    /**
     * Unique user identifier defined by merchant
     *
     * @param $value
     * @return Payout
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setUserId($value)
    {
        return $this->setLimitedString(
            'user_id',
            $value,
            null,
            self::USER_ID_MAX_LENGTH
        );
    }

    /**
     * The payment type
     *
     * @param $value
     * @return Payout
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setPaymentType($value)
    {
        if (empty($value)) {
            $this->payment_type = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'payment_type',
            PayoutPaymentTypesParameters::getAll(),
            $value,
            'Invalid payment_type.'
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
            'transaction_id',
            'amount',
            'currency',
            'notification_url',
            'return_success_url',
            'return_failure_url',
            'remote_ip',
            'billing_first_name',
            'billing_last_name',
            'billing_state',
            'billing_country'
        ];

        $this->requiredFields = Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'currency' => PayoutBankParameters::getAllowedCurrencies()
        ];

        $this->requiredFieldValues = Common::createArrayObject($requiredFieldValues);

        $this->setRequiredFieldsConditional();
    }

    /**
     * Set the required fields conditional
     *
     * @return void
     */
    protected function setRequiredFieldsConditional()
    {
        $requiredFieldValuesConditional = [
            'currency' => [
                'ARS' => [
                    ['bank_name' => PayoutBankParameters::getBankNamesPerCurrency('ARS')]
                ],
                'BRL' => [
                    ['bank_name' => PayoutBankParameters::getBankNamesPerCurrency('BRL')]
                ],
                'CAD' => [
                    ['bank_name' => PayoutBankParameters::getBankNamesPerCurrency('CAD')]
                ],
                'CLP' => [
                    ['bank_name' => PayoutBankParameters::getBankNamesPerCurrency('CLP')]
                ],
                'CNY' => [
                    ['bank_name' => PayoutBankParameters::getBankNamesPerCurrency('CNY')]
                ],
                'COP' => [
                    ['bank_name' => PayoutBankParameters::getBankNamesPerCurrency('COP')]
                ],
                'IDR' => [
                    ['bank_name' => PayoutBankParameters::getBankNamesPerCurrency('IDR')]
                ],
                'INR' => [
                    ['bank_name' => PayoutBankParameters::getBankNamesPerCurrency('INR')]
                ],
                'MYR' => [
                    ['bank_name' => PayoutBankParameters::getBankNamesPerCurrency('MYR')]
                ],
                'MXN' => [
                    ['bank_name' => PayoutBankParameters::getBankNamesPerCurrency('MXN')]
                ],
                'PEN' => [
                    ['bank_name' => PayoutBankParameters::getBankNamesPerCurrency('PEN')]
                ],
                'THB' => [
                    ['bank_name' => PayoutBankParameters::getBankNamesPerCurrency('THB')]
                ],
                'UYU' => [
                    ['bank_name' => PayoutBankParameters::getBankNamesPerCurrency('UYU')]
                ]
            ]
        ];

        $this->requiredFieldValuesConditional = Common::createArrayObject($requiredFieldValuesConditional);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return array_merge(
            [
                'amount'                          => $this->transformAmount($this->amount, $this->currency),
                'currency'                        => $this->currency,
                'customer_email'                  => $this->customer_email,
                'customer_phone'                  => $this->customer_phone,
                'notification_url'                => $this->notification_url,
                'return_success_url'              => $this->return_success_url,
                'return_failure_url'              => $this->return_failure_url,
                'bank_code'                       => $this->bank_code,
                'bank_name'                       => $this->bank_name,
                'bank_branch'                     => $this->bank_branch,
                'bank_account_name'               => $this->bank_account_name,
                'bank_account_number'             => $this->bank_account_number,
                'bank_province'                   => $this->bank_province,
                'id_card_number'                  => $this->id_card_number,
                'payer_bank_account_number'       => $this->payer_bank_phone_number,
                'bank_account_type'               => $this->bank_account_type,
                'bank_account_verification_digit' => $this->bank_account_verification_digit,
                'document_type'                   => $this->document_type,
                'account_id'                      => $this->account_id,
                'user_id'                         => $this->user_id,
                'birth_date'                      => $this->getBirthDate(),
                'payment_type'                    => $this->payment_type,
                'billing_address'                 => $this->getBillingAddressParamsStructure(),
                'shipping_address'                => $this->getShippingAddressParamsStructure()
            ],
            $this->getCustomerParamsStructure()
        );
    }

    /**
     * Perform field validation
     *
     * @return void
     * @throws ErrorParameter
     * @throws InvalidArgument
     * @throws InvalidClassMethod
     */
    protected function checkRequirements()
    {
        $this->validateBRLCurrency();
        parent::checkRequirements();
    }

    /**
     * If the currency is BRL at least one of the parameters bank_code or bank_name should be set
     * @return void
     * @throws ErrorParameter
     */
    protected function validateBRLCurrency()
    {
        if ($this->currency != 'BRL') {
            return;
        }

        $requiredFieldsGroups = [
            'currency' => ['bank_code', 'bank_name'],
        ];
        $this->requiredFieldsGroups = Common::createArrayObject($requiredFieldsGroups);

        // Allow empty bank_name with non-empty bank_code
        if (!empty($this->bank_code)) {
            $requiredFieldValuesConditional                      = (array)$this->requiredFieldValuesConditional;
            $requiredFieldValuesConditional['currency']['BRL'][] = ['bank_code' => $this->bank_code];

            $this->requiredFieldValuesConditional = Common::createArrayObject($requiredFieldValuesConditional);
        }
    }
}
