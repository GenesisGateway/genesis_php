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

namespace Genesis\Api\Request\Financial\OnlineBankingPayments\OnlineBanking;

use Genesis\Api\Constants\BankAccountTypes;
use Genesis\Api\Constants\Transaction\Parameters\OnlineBanking\PayoutBankParameters;
use Genesis\Api\Constants\Transaction\Parameters\OnlineBanking\PayoutPaymentTypesParameters;
use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\DocumentAttributes;
use Genesis\Api\Traits\Request\Financial\AsyncAttributes;
use Genesis\Api\Traits\Request\Financial\BirthDateAttributes;
use Genesis\Api\Traits\Request\Financial\CustomerAttributes;
use Genesis\Api\Traits\Request\Financial\NotificationAttributes;
use Genesis\Api\Traits\Request\Financial\OnlineBankingPayments\PayerAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Exceptions\InvalidClassMethod;
use Genesis\Utils\Common;
use Genesis\Api\Traits\Request\Financial\UcofAttributes;

/**
 * Class Payout
 *
 * OnlineBanking Payout - oBeP-style alternative payment method
 *
 * @package Genesis\Api\Request\Financial\OnlineBankingPayments\OnlineBanking
 *
 * @method Payout setBankAccountName($value) Set Customer’s bank account name
 * @method Payout setBankAccountNumber($value) Set Customer’s bank account number
 * @method Payout setBankName($value) Set Customer’s bank name
 * @method Payout setBankCode($value) Set Customer’s bank code
 * @method Payout setBankBranch($value) Set Customer’s bank branch
 * @method Payout setBankProvince($value) Set Name of the province that the bank is located
 * @method Payout setPixKey($value)
 * @method string getPaymentType() Get Payment type
 * @method string getPixKey()
 */
class Payout extends \Genesis\Api\Request\Base\Financial
{
    use AddressInfoAttributes;
    use AsyncAttributes;
    use BirthDateAttributes;
    use CustomerAttributes;
    use DocumentAttributes;
    use NotificationAttributes;
    use PaymentAttributes;
    use PayerAttributes;

    const ID_CARD_NUMBER_MAX_LENGTH          = 30;
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
     * The type of account.
     *     C: for Checking accounts
     *     S: for Savings accounts
     *     M: for Maestra accounts(Only Peru)
     *     P: for Payment accounts
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

    /**
     * PIX key of the customer.
     *
     * @var string $pix_key
     */
    protected $pix_key;

    protected function getTransactionType()
    {
        return \Genesis\Api\Constants\Transaction\Types::ONLINE_BANKING_PAYOUT;
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
                'bank_account_type'               => $this->bank_account_type,
                'bank_account_verification_digit' => $this->bank_account_verification_digit,
                'document_type'                   => $this->document_type,
                'account_id'                      => $this->account_id,
                'user_id'                         => $this->user_id,
                'birth_date'                      => $this->getBirthDate(),
                'payment_type'                    => $this->payment_type,
                'billing_address'                 => $this->getBillingAddressParamsStructure(),
                'shipping_address'                => $this->getShippingAddressParamsStructure(),
                'pix_key'                         => $this->pix_key,
                'document_id'                     => $this->getDocumentId(),
                'payer'                           => $this->getPayerParametersStructure()
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
        $this->validateDocumentId();
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
            'BRL Currency' => ['bank_code', 'bank_name']
        ];
        $this->requiredFieldsGroups = Common::createArrayObject($requiredFieldsGroups);

        // Allow empty bank_name, only with Group bank_code and bank_name requirement
        if (empty($this->bank_name)) {
            unset($this->requiredFieldValuesConditional['currency']['BRL']);
        }
    }

    /**
     * Add Document ID validations only if document_id variable is set
     *
     * @return void
     */
    protected function validateDocumentId()
    {
        if (empty($this->document_id)) {
            return;
        }

        $requiredFieldValuesConditional = (array) $this->requiredFieldValuesConditional;

        $requiredFieldValuesConditional = array_merge(
            $requiredFieldValuesConditional,
            $this->getDocumentIdConditions()
        );

        $this->requiredFieldValuesConditional = Common::createArrayObject($requiredFieldValuesConditional);
    }
}
