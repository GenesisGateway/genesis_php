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

namespace Genesis\Api\Request\NonFinancial\Installments;

use Genesis\Api\Request\Base\BaseVersionedRequest;
use Genesis\Api\Traits\RestrictedSetter;
use Genesis\Api\Validators\Request\RegexValidator;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Currency;

/**
 * Class Installment Fetch
 *
 * Installments fetch request
 *
 * @method $this  setCurrency(string $value)   Set the currency
 * @method $this  setAmount(int $value)        Get the amount
 * @method $this  setCardNumber(string $value) Get the card number
 * @method string getCurrency()                Get the currency
 * @method int    getAmount()                  Get the amount
 *
 * @package Genesis\Api\Request\NonFinancial\Installments
 */
class Fetch extends BaseVersionedRequest
{
    use RestrictedSetter;

    /**
     * Amount
     *
     * @var int
     */
    protected $amount;

    /**
     * Currency
     *
     * @var string
     */
    protected $currency;

    /**
     * Credit card number
     *
     * @var string
     */
    protected $card_number;

    /**
     * Fetch constructor.
     */
    public function __construct()
    {
        parent::__construct('installments/');
    }

    /**
     * Get the card number
     *
     * @return string
     */
    public function getCardNumber()
    {
        return (string) $this->card_number;
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields       = [
            'amount',
            'currency',
            'card_number'
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues       = [
            'currency'    => Currency::getList(),
            'amount'      => new RegexValidator('/^\d+$/'),
            'card_number' => new RegexValidator(RegexValidator::PATTERN_CREDIT_CARD_NUMBER)
        ];
        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }

    /**
     * Get the request structure
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'amount'       => (int) $this->amount,
            'currency'     => $this->currency,
            'card_number'  => $this->getCardNumber(),
        ];
    }
}
