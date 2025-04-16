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

namespace Genesis\Api\Traits\Request\Financial\OnlineBankingPayments;

/**
 * Trait PayerAttributes
 *
 * @package Genesis\Api\Traits\Request\Financial\OnlineBankingPayments
 *
 */

use Genesis\Api\Traits\MagicAccessors;
use Genesis\API\Traits\RestrictedSetter;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait PayerAttributes
 *
 * @package Genesis\Api\Traits\Request\Financial\OnlineBankingPayments
 *
 * @method string getPayerDocumentId
 * @method string getPayerBankCode
 * @method string getPayerBankAccountNumber
 * @method string getPayerBankBranch
 * @method string getPayerBankAccountVerificationDigit
 * @method string getPayerBankPhoneNumber
 */
trait PayerAttributes
{
    use RestrictedSetter;

    /**
     * Payer document ID. CPF (for individuals) or CNPJ (for legal entities) in Brazil.
     *
     * @var string
     */
    protected $payer_document_id;

    /**
     * The bank code used to process the transaction.
     *
     * @var string
     */
    protected $payer_bank_code;

    /**
     * The payer's bank account number.
     *
     * @var string
     */
    protected $payer_bank_account_number;

    /**
     * The name of the bank branch where the account is held.
     *
     * @var string
     */
    protected $payer_bank_branch;

    /**
     * Single - digit verification code assigned by the external provider, used to validate the bank account.
     *
     * @var string
     */
    protected $payer_bank_account_verification_digit;

    /**
     * The payer's bank contact phone number.
     *
     * @var string
     */
    protected $payer_bank_phone_number;

    /**
     * Set the payer document id
     *
     * @param string $value
     *
     * @throws InvalidArgument
     */
    public function setPayerDocumentId($value)
    {
        if ($value === null) {
            $this->payer_document_id = null;

            return $this;
        }

        return $this->setLimitedString('payer_document_id', $value, null, 16);
    }

    /**
     * Set the payer bank code
     *
     * @param string $value
     *
     * @throws InvalidArgument
     */
    public function setPayerBankCode($value)
    {
        if ($value === null) {
            $this->payer_bank_code = null;

            return $this;
        }

        return $this->setLimitedString('payer_bank_code', $value, null, 12);
    }

    /**
     * Set the payer bank account number
     *
     * @param string $value
     *
     * @throws InvalidArgument
     */
    public function setPayerBankAccountNumber($value)
    {
        if ($value === null) {
            $this->payer_bank_account_number = null;

            return $this;
        }

        return $this->setLimitedString('payer_bank_account_number', $value, null, 33);
    }

    /**
     * Set the payer bank branch
     *
     * @param string $value
     *
     * @throws InvalidArgument
     */
    public function setPayerBankBranch($value)
    {
        if ($value === null) {
            $this->payer_bank_branch = null;

            return $this;
        }

        return $this->setLimitedString('payer_bank_branch', $value, null, 11);
    }

    /**
     * Set the payer bank account verification digit
     *
     * @param string $value
     *
     * @throws InvalidArgument
     */
    public function setPayerBankAccountVerificationDigit($value)
    {
        if ($value === null) {
            $this->payer_bank_account_verification_digit = null;

            return $this;
        }

        return $this->setLimitedString('payer_bank_account_verification_digit', $value, null, 1);
    }

    /**
     * Set the payer bank phone number
     *
     * @param string $value
     *
     * @throws InvalidArgument
     */
    public function setPayerBankPhoneNumber($value)
    {
        if ($value === null) {
            $this->payer_bank_phone_number = null;

            return $this;
        }

        return $this->setLimitedString('payer_bank_phone_number', $value, null, 11);
    }

    /**
     * Get the payer parameters structure
     *
     * @return array
     */
    protected function getPayerParametersStructure()
    {
        return [
            'document_id'                     => $this->payer_document_id,
            'bank_code'                       => $this->payer_bank_code,
            'bank_account_number'             => $this->payer_bank_account_number,
            'bank_branch'                     => $this->payer_bank_branch,
            'bank_account_verification_digit' => $this->payer_bank_account_verification_digit,
            'bank_phone_number'               => $this->payer_bank_phone_number
        ];
    }
}
