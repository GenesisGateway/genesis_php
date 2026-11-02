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

namespace Genesis\Api\Request\NonFinancial\Kyc\BankAccount;

use Genesis\Api\Constants\NonFinancial\Kyc\BankAccountTypes;
use Genesis\Api\Request\Base\NonFinancial\Kyc\BaseRequest as KYCBaseRequest;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class BankAccountVerification
 *
 * Verify that a given bank account (identified by its account number and sort code) belongs to a named
 * holder, and whether the declared account type matches the record held by the bank.
 *
 * @method $this  setBankAccountName(string $value)   Set the holder name of the bank account
 * @method string getBankAccountName()                Get the holder name of the bank account
 * @method string getBankAccountNumber()              Get the number of the bank account
 * @method string getBankAccountType()                Get the account type related to the account number
 * @method string getSortCode()                       Get the bank identifier for the related account
 * @method string getReferenceId()                    Get the unique verification identifier
 *
 * @package Genesis\Api\Request\NonFinancial\Kyc\BankAccount
 */
class BankAccountVerification extends KYCBaseRequest
{
    /**
     * The holder name of the bank account number.
     *
     * @var string
     */
    protected $bank_account_name;

    /**
     * The number of the bank account.
     *
     * @var string(8)
     */
    protected $bank_account_number;

    /**
     * The account type related to the account number. Possible values: Business or Personal.
     *
     * @var string
     */
    protected $bank_account_type;

    /**
     * An identifier of the bank for the related account.
     *
     * @var string(6)
     */
    protected $sort_code;

    /**
     * Unique value to identify the performed verification.
     *
     * @var string(32)
     */
    protected $reference_id;

    /**
     * BankAccountVerification constructor
     */
    public function __construct()
    {
        parent::__construct('bank_account_verification');
    }

    /**
     * Set the account type related to the account number
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBankAccountType($value)
    {
        if (empty($value)) {
            $this->bank_account_type = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'bank_account_type',
            BankAccountTypes::getAll(),
            $value,
            'Invalid bank account type.'
        );
    }

    /**
     * Set the number of the bank account
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setBankAccountNumber($value)
    {
        return $this->setLimitedString('bank_account_number', $value, null, 8);
    }

    /**
     * Set the bank identifier for the related account
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setSortCode($value)
    {
        return $this->setLimitedString('sort_code', $value, null, 6);
    }

    /**
     * Set the unique value to identify the performed verification
     *
     * @param string $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setReferenceId($value)
    {
        if (empty($value)) {
            $this->reference_id = null;

            return $this;
        }

        return $this->setLimitedString('reference_id', $value, null, 32);
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields       = [
            'bank_account_name',
            'bank_account_number',
            'bank_account_type',
            'sort_code'
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues       = [
            'bank_account_type' => BankAccountTypes::getAll(),
        ];
        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }

    /**
     * Create the request's Tree structure
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'bank_account_name'   => $this->bank_account_name,
            'bank_account_number' => $this->bank_account_number,
            'bank_account_type'   => $this->bank_account_type,
            'sort_code'           => $this->sort_code,
            'reference_id'        => $this->reference_id
        ];
    }
}
