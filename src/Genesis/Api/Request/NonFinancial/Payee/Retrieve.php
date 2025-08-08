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

namespace Genesis\Api\Request\NonFinancial\Payee;

use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\PayeeAttributes;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common as CommonUtils;

/**
 * Retrieve the details of a specific a Payee record based on it's unique ID.
 *
 * @package Genesis\Api\Request\NonFinancial\Payee
 *
 * @method string getPayeeUniqueId() Returns the unique identifier of the Payee
 *
 */
class Retrieve extends BaseRequest
{
    use PayeeAttributes;

    const REQUEST_PATH = 'payee/:payee_unique_id';

    /**
     * Retrieve constructor.
     */
    public function __construct()
    {
        parent::__construct(self::REQUEST_PATH);
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
        $this->setRequestPath(
            str_replace(
                ':payee_unique_id',
                (string)$this->payee_unique_id,
                self::REQUEST_PATH
            )
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
            'payee_unique_id'
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * Configures a Secured Post Request with JSON body
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
