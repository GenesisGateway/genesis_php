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
 * @copyright   Copyright (C) 2015-2024 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\Financial\Refund;

use Genesis\Api\Constants\Transaction\Parameters\Refund\BankAccountTypeParameters;

/**
 * Trait BankAttributes
 * @package Genesis\Api\Traits\Request\Financial\Refund
 *
 * @method $this setBank($value) Name of the customer's bank
 * @method $this setBankBranch($value) Name of the Bank branch
 * @method $this setBankAccount($value) Bank account number of the customer
 */
trait BankAttributes
{
    /**
     *  Name of the customer's bank
     *
     * @var string $bank
     */
    protected $bank;

    /**
     * Name of the Bank branch
     *
     * @var string $bank_branch
     */
    protected $bank_branch;

    /**
     * Bank account number of the customer
     *
     * @var string $bank_account
     */
    protected $bank_account;

    /**
     * The type of account
     *     C: for Checking accounts
     *     S: for Savings accounts
     *     I: for International accounts
     *
     * @var string $bank_account_type
     */
    protected $bank_account_type;

    /**
     * The type of account
     *
     * @param string $value
     * @return $this
     */
    public function setBankAccountType($value)
    {
        return $this->allowedOptionsSetter(
            'bank_account_type',
            BankAccountTypeParameters::getAll(),
            $value,
            'Provided value for bank_account_type is not allowed.'
        );
    }

    /**
     * Returns structure with bank attributes for Request
     *
     * @return array
     */
    protected function getBankAttributesStructure()
    {
        return [
            'bank'              => $this->bank,
            'bank_branch'       => $this->bank_branch,
            'bank_account'      => $this->bank_account,
            'bank_account_type' => $this->bank_account_type
        ];
    }
}
