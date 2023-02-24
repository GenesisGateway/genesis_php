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

namespace Genesis\API\Traits\Request\NonFinancial;

use Genesis\API\Constants\NonFinancial\KYC\CVVPresents;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait PaymentDetails
 * @package Genesis\API\Traits\Request\NonFinancial
 */
trait PaymentDetails
{
    /**
     * First 6 digits of the card number; Only required if Payment Method Type is Credit Card;
     *
     * @var string
     */
    protected $bin;

    /**
     * Last 4 digits of the card number; Only required if Payment Method Type is Credit Card;
     *
     * @var string
     */
    protected $tail;

    /**
     * Indicator if the CVV was received or not; The expected values in this field are Yes or No;
     *
     * @var string
     */
    protected $cvv_present;

    /**
     * Only required if Payment Method Type is Credit Card; It should be hashed using SHA256;
     * the string to be hashed is Card Number and the MD5 hash of the Expiration Date; For example;
     * if the card number is 1111-2222-3333-4444 with expiration date 01/22;
     * The have should be done on the string without spaces nor dash nor other special chars;
     * The MD5 of the Expiration Date 0122 is f0f4b6598f2cee45644673998b4f44be; That said;
     * the string to be hashed is 1111222233334444f0f4b6598f2cee45644673998b4f44be
     * which generates the following result fecd244b7d647b0db391e35910e0d42aaf88f7633a4f4f4883b109abad1d6d7
     *
     * @var string
     */
    protected $hashed_pan;

    /**
     * Routing number; Only required if Payment Method Type is eCheck;
     *
     * @var string
     */
    protected $routing;

    /**
     * Only numbers up to 30 digits; Only required if Payment Method Type is eCheck;
     *
     * @var string
     */
    protected $account;

    /**
     * Most of the times its an email; Only required if Payment Method Type is eWallet;
     *
     * @var string
     */
    protected $ewallet_id;

    /**
     * @param $bin
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setBin($bin)
    {
        if (!preg_match('/^\d{6}$/', $bin)) {
            throw new InvalidArgument('Bin must be 6 digits.');
        }

        $this->bin = $bin;

        return $this;
    }

    /**
     * @param $tail
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setTail($tail)
    {
        if (!preg_match('/^\d{4}$/', $tail)) {
            throw new InvalidArgument('Tail must be 4 digits.');
        }

        $this->tail = $tail;

        return $this;
    }

    /**
     * @param $account
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setAccount($account)
    {
        if (!preg_match('/^\d{1,30}$/', $account)) {
            throw new InvalidArgument('Account must be between 1 and 30 digits.');
        }

        $this->account = $account;

        return $this;
    }

    /**
     * @param $cvvPresent
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setCvvPresent($cvvPresent)
    {
        return $this->allowedOptionsSetter(
            'cvv_present',
            CVVPresents::getAll(),
            $cvvPresent,
            'Invalid cvv present indicator.'
        );
    }

    /**
     * @return array
     */
    public function getPaymentDetailsStructure()
    {
        return [
            'bin'         => $this->bin,
            'tail'        => $this->tail,
            'cvv_present' => $this->cvv_present,
            'hashed_pan'  => $this->hashed_pan,
            'routing'     => $this->routing,
            'account'     => $this->account,
            'ewallet_id'  => $this->ewallet_id
        ];
    }
}
