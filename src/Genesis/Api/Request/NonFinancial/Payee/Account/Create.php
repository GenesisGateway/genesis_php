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

namespace Genesis\Api\Request\NonFinancial\Payee\Account;

use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\PayeeAttributes;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Country;

/**
 * Class Create account
 *
 * Handles the creation of a payee account.
 *
 * @package Genesis\Api\Request\NonFinancial\Payee\Account
 *
 * @method $this setPayeeAccountType(string $value)            Sets the type of the account (iban or bank)
 * @method $this setPayeeAccountNumber(string $value)          Sets the account number
 * @method $this setPayeeAccountCountry(string $value)         Sets the country code in ISO 3166
 * @method $this setPayeeAccountInstitutionCode(string $value) Sets the institution code of the account number
 * @method string getPayeeUniqueId()                           Returns the payee unique ID
 * @method string getPayeeAccountType()                        Returns the type of the account
 * @method string getPayeeAccountNumber()                      Returns the account number
 * @method string getPayeeAccountCountry()                     Returns the country code in ISO 3166
 * @method string getPayeeAccountInstitutionCode()             Returns the institution code of the account number
 *
 */
class Create extends BaseRequest
{
    use PayeeAttributes;

    const REQUEST_PATH = 'payee/:payee_unique_id/account';

    /**
     * The type of the Account. Can be iban or bank.
     *
     * @var string
     */
    protected $payee_account_type;

    /**
     * The Account number.
     *
     * @var string
     */
    protected $payee_account_number;

    /**
     * Country code in ISO 3166. If not provided, it will be assumed that the account country is the same
     * as the country of the payee to which it belongs.
     *
     * @var string
     */
    protected $payee_account_country;

    /**
     * The institution code of the account number. It is used when the type is bank and must contain either
     * a Bank Identifier Code (BIC) or a National Clearing Code (NCC).
     *
     * @var string
     */
    protected $payee_account_institution_code;

    /**
     * Create constructor.
     */
    public function __construct()
    {
        parent::__construct(self::REQUEST_PATH);
    }

    /**
     * Updates the request path with proper payee unique ID
     *
     * @throws EnvironmentNotSet
     */
    protected function updateRequestPath()
    {
        $this->setRequestPath(
            str_replace(
                ':payee_unique_id',
                (string) $this->payee_unique_id,
                self::REQUEST_PATH
            )
        );
    }

    /**
     * Set validation rules for required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'payee_unique_id',
            'payee_account_type',
            'payee_account_number',
        ];
        $this->requiredFields = Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'payee_account_type' => ['iban', 'bank'],
            'payee_account_country'      => Country::getList()
        ];
        $this->requiredFieldValues = Common::createArrayObject($requiredFieldValues);

        $requiredFieldsConditional = [
            'payee_account_type' => [
                'bank' => ['payee_account_institution_code']
            ]
        ];
        $this->requiredFieldsConditional = CommonUtils::createArrayObject($requiredFieldsConditional);
    }

    /**
     * Get the request structure for the API call
     *
     * @return array[]
     */
    protected function getRequestStructure()
    {
        return [
            'account' => [
                'type'             => $this->payee_account_type,
                'number'           => $this->payee_account_number,
                'institution_code' => $this->payee_account_institution_code,
                'country'          => $this->payee_account_country,
            ]
        ];
    }
}
