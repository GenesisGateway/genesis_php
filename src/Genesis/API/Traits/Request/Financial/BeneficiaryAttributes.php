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

namespace Genesis\API\Traits\Request\Financial;

/**
 * Trait BeneficiaryAttributes
 * @package Genesis\API\Traits\Request\Financial
 *
 * @method setBeneficiaryBankCode($value) The bank code of the beneficiary's bank
 * @method setBeneficiaryName($value) The name of the beneficiary's bank
 * @method setBeneficiaryAccountNumber($value) The account number of the beneficiary in his bank
 */
trait BeneficiaryAttributes
{
    /**
     * The bank code of the beneficiary's bank
     *
     * @var $beneficiary_bank_code
     */
    protected $beneficiary_bank_code;

    /**
     * The name of the beneficiary's bank
     *
     * @var $beneficiary_name
     */
    protected $beneficiary_name;

    /**
     * The account number of the beneficiary in his bank
     *
     * @var $beneficiary_account_number
     */
    protected $beneficiary_account_number;

    protected function getBeneficiaryAttributesStructure()
    {
        return [
            'beneficiary_bank_code'      => $this->beneficiary_bank_code,
            'beneficiary_name'           => $this->beneficiary_name,
            'beneficiary_account_number' => $this->beneficiary_account_number
        ];
    }
}
