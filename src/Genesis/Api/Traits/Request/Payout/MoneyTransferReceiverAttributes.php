<?php

/**
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author      emerchantpay
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\Payout;

use Genesis\Utils\Country;

/**
 * Trait MoneyTransferReceiverAttributes
 * @package Genesis\Api\Traits\Request\Payout
 *
 * @method string|null getMoneyTransferReceiverFirstName()
 * @method string|null getMoneyTransferReceiverLastName()
 * @method string|null getMoneyTransferReceiverCountry()
 * @method string|null getMoneyTransferReceiverCity()
 * @method string|null getMoneyTransferReceiverState()
 * @method string|null getMoneyTransferReceiverZipCode()
 * @method string|null getMoneyTransferReceiverAddress1()
 *
 * @method $this setMoneyTransferReceiverFirstName($value)
 */
trait MoneyTransferReceiverAttributes
{
    /**
     * Receiver first name.
     * @var string|null $money_transfer_receiver_first_name
     */
    protected $money_transfer_receiver_first_name;

    /**
     * Receiver last name.
     * @var string|null $money_transfer_receiver_last_name
     */
    protected $money_transfer_receiver_last_name;

    /**
     * Receiver country code in ISO 3166.
     * @var string|null $money_transfer_receiver_country
     */
    protected $money_transfer_receiver_country;

    /**
     * Receiver city.
     * @var string|null $money_transfer_receiver_city
     */
    protected $money_transfer_receiver_city;

    /**
     * Receiver state code in ISO 3166-2.
     * @var string|null $money_transfer_receiver_state
     */
    protected $money_transfer_receiver_state;

    /**
     * Receiver ZIP code.
     * @var string|null $money_transfer_receiver_zip_code
     */
    protected $money_transfer_receiver_zip_code;

    /**
     * Receiver primary address.
     * @var string|null $money_transfer_receiver_address1
     */
    protected $money_transfer_receiver_address1;

    /**
     * Set the receiver last name.
     *
     * @param $value
     * @return $this
     */
    public function setMoneyTransferReceiverLastName($value)
    {
        return $this->setLimitedString(
            'money_transfer_receiver_last_name',
            $value,
            null,
            30
        );
    }

    /**
     * Set the receiver country (ISO 3166 alpha-2).
     *
     * `null` and `''` clear the value; any other value outside Country::getList() throws.
     *
     * @param $value
     * @return $this
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setMoneyTransferReceiverCountry($value)
    {
        if ($value === '') {
            $value = null;
        }

        return $this->allowedOptionsStrictSetter(
            'money_transfer_receiver_country',
            Country::getList(),
            $value,
            'Invalid value for Money Transfer Receiver Country.'
        );
    }

    /**
     * Set the receiver city.
     *
     * @param $value
     * @return $this
     */
    public function setMoneyTransferReceiverCity($value)
    {
        return $this->setLimitedString(
            'money_transfer_receiver_city',
            $value,
            null,
            15
        );
    }

    /**
     * Set the receiver state.
     *
     * @param $value
     * @return $this
     */
    public function setMoneyTransferReceiverState($value)
    {
        return $this->setLimitedString(
            'money_transfer_receiver_state',
            $value,
            null,
            3
        );
    }

    /**
     * Set the receiver ZIP code.
     *
     * @param $value
     * @return $this
     */
    public function setMoneyTransferReceiverZipCode($value)
    {
        return $this->setLimitedString(
            'money_transfer_receiver_zip_code',
            $value,
            null,
            10
        );
    }

    /**
     * Set the receiver primary address.
     *
     * @param $value
     * @return $this
     */
    public function setMoneyTransferReceiverAddress1($value)
    {
        return $this->setLimitedString(
            'money_transfer_receiver_address1',
            $value,
            null,
            25
        );
    }

    /**
     * Return the receiver structure.
     *
     * @return array
     */
    protected function getMoneyTransferReceiverStructure()
    {
        return [
            'first_name' => $this->money_transfer_receiver_first_name,
            'last_name'  => $this->money_transfer_receiver_last_name,
            'country'    => $this->money_transfer_receiver_country,
            'city'       => $this->money_transfer_receiver_city,
            'zip_code'   => $this->money_transfer_receiver_zip_code,
            'address1'   => $this->money_transfer_receiver_address1,
            'state'      => $this->money_transfer_receiver_state,
        ];
    }

    /**
     * Return receiver conditional validation rules.
     *
     * Any receiver attribute requires both receiver names.
     *
     * @return array
     */
    protected function requiredMoneyTransferReceiverFieldsConditional()
    {
        $names = [
            'money_transfer_receiver_first_name',
            'money_transfer_receiver_last_name',
        ];

        return [
            'money_transfer_receiver_first_name' => ['money_transfer_receiver_last_name'],
            'money_transfer_receiver_last_name'  => ['money_transfer_receiver_first_name'],
            'money_transfer_receiver_country'    => $names,
            'money_transfer_receiver_city'       => $names,
            'money_transfer_receiver_state'      => $names,
            'money_transfer_receiver_zip_code'   => $names,
            'money_transfer_receiver_address1'   => $names,
        ];
    }
}
