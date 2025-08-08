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
use Genesis\Utils\Common as CommonUtils;

/**
 * Class ListAccounts
 *
 * Handles the listing of accounts for a specific payee.
 *
 * @package Genesis\Api\Request\NonFinancial\Payee\Account
 *
 * @method string getPayeeUniqueId()     Returns the unique identifier of the Payee
 * @method string getNumberEq()          Returns the account number filter
 * @method string getTypeEq()            Returns the account type filter
 * @method string getInstitutionCodeEq() Returns the institution code filter
 *
 */
class ListAccounts extends BaseRequest
{
    use PayeeAttributes;

    const REQUEST_PATH = 'payee/:payee_unique_id/account';

    /**
     * Filter by exact account number.
     *
     * @var string|null
     */
    protected $number_eq;

    /**
     * Filter by exact account type.
     *
     * @var string|null
     */
    protected $type_eq;

    /**
     * Filter by exact institution code.
     *
     * @var string|null
     */
    protected $institution_code_eq;

    /**
     * Retrieve constructor.
     */
    public function __construct()
    {
        parent::__construct(self::REQUEST_PATH);
    }

    /**
     * Sets the account number filter.
     *
     * @param string $value
     *
     * @return $this
     *
     * @throws EnvironmentNotSet
     */
    public function setNumberEq($value)
    {
        $this->number_eq = $value;
        $this->updateRequestPath();

        return $this;
    }

    /**
     * Sets the account type filter.
     *
     * @param string $value
     *
     * @return $this
     *
     * @throws EnvironmentNotSet
     */
    public function setTypeEq($value)
    {
        $this->type_eq = $value;
        $this->updateRequestPath();

        return $this;
    }

    /**
     * Sets the institution code filter.
     *
     * @param string $value
     *
     * @return $this
     *
     * @throws EnvironmentNotSet
     */
    public function setInstitutionCodeEq($value)
    {
        $this->institution_code_eq = $value;
        $this->updateRequestPath();

        return $this;
    }

    /**
     * Updates the request path with payee_unique_id and query parameters.
     *
     * @return $this
     *
     * @throws EnvironmentNotSet
     */
    protected function updateRequestPath()
    {
        $path        = str_replace(
            ':payee_unique_id',
            (string)$this->payee_unique_id,
            self::REQUEST_PATH
        );

        $queryParams = array_filter([
            'number_eq'           => $this->number_eq,
            'type_eq'             => $this->type_eq,
            'institution_code_eq' => $this->institution_code_eq
        ], function ($value) {
            return $value !== null;
        });

        if (!empty($queryParams)) {
            $path .= '?' . http_build_query($queryParams);
        }

        $this->setRequestPath($path);
    }

    /**
     * Set the required fields.
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields       = [
            'payee_unique_id'
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * Configures a Secured GET Request with JSON response.
     *
     * @return void
     */
    protected function initJsonConfiguration()
    {
        $this->setGetRequest();
    }

    /**
     * Returns an empty request structure (GET requests don't need a body).
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [];
    }
}
