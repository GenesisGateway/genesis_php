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

namespace Genesis\Api\Traits\Request\Financial;

/**
 * Trait AccountOwnerAttributes
 *
 * Account owner parameters related to account owner inquiry requests
 *
 * @package Genesis\Api\Traits\Request\Financial
 *
 * @method $this  setAccountFirstName($value) Set Account owner's first name
 * @method $this  setAccountMiddleName($value) Set Account owner's middle name
 * @method $this  setAccountLastName($value) Set Account owner's last name
 * @method string getAccountFirstName() Get Account owner's first name
 * @method string getAccountMiddleName() Get Account owner's middle name
 * @method string getAccountLastName() Get Account owner's last name
 */
trait AccountOwnerAttributes
{
    /**
     * Account owner's first name
     *
     * @var string
     */
    protected $account_first_name;

    /**
     * Account owner's middle name
     *
     * @var string
     */
    protected $account_middle_name;

    /**
     * Account owner's last name
     *
     * @var string
     */
    protected $account_last_name;

    /**
     * Account owner parameters structure
     *
     * @return array
     */
    protected function getAccountOwnerAttributesStructure()
    {
        return [
            'first_name'  => $this->account_first_name,
            'middle_name' => $this->account_middle_name,
            'last_name'   => $this->account_last_name
        ];
    }
}
