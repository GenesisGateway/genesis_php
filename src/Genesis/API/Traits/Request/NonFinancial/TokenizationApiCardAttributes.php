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

use Genesis\API\Validators\Request\RegexValidator;

/**
 * Trait TokenizationApiCardAttributes
 *
 * @package Genesis\API\Traits\Request\NonFinancial
 *
 * @method $this setCardNumber($value) Set Complete CC number of customer
 * @method $this setCardHolder($value) Set Full name of customer as printed on credit card
 * @method $this setExpirationMonth($value) Set Expiration month as printed on credit card
 * @method $this setExpirationYear($value) Set Expiration year as printed on credit card
 * @method string getCardNumber() Get Complete CC number of customer
 * @method string getCardHolder() Get Full name of customer as printed on credit card
 * @method string getExpirationMonth() Get Expiration month as printed on credit card
 * @method string getExpirationYear() Get Expiration year as printed on credit card
 */
trait TokenizationApiCardAttributes
{
    /**
     * Complete CC number of customer
     *
     * @var string
     */
    protected $card_number;

    /**
     * Full name of customer as printed on credit card (first name and last name at least)
     *
     * @var string
     */
    protected $card_holder;

    /**
     * Expiration month as printed on credit card
     *
     * @var string (mm)
     */
    protected $expiration_month;

    /**
     * Expiration year as printed on credit card
     *
     * @var string (yyyy)
     */
    protected $expiration_year;

    /**
     * Instance of CC Number Format Validator
     *
     * @return RegexValidator
     */
    protected function getCreditCardNumberValidator()
    {
        return new RegexValidator(
            RegexValidator::PATTERN_CREDIT_CARD_NUMBER
        );
    }

    /**
     * Returns a list with CC Card Number Validator
     *
     * @return array
     */
    protected function getCCNumberValueFormatValidator()
    {
        return [
            'card_number' => $this->getCreditCardNumberValidator()
        ];
    }

    /**
     * @return array
     */
    protected function getCreditCardParamsStructure()
    {
        return [
            'card_number'      => $this->card_number,
            'card_holder'      => $this->card_holder,
            'expiration_month' => $this->expiration_month,
            'expiration_year'  => $this->expiration_year
        ];
    }
}
