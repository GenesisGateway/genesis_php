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

namespace Genesis\Api\Traits\Request;

use Genesis\Api\Traits\Request\Financial\BirthDateAttributes;
use Genesis\Api\Validators\Request\RegexValidator;
use Genesis\Utils\Common;
use Genesis\Utils\Common as CommonUtils;

/**
 * Trait CreditCardAttributes
 * @package Genesis\Api\Traits\Request
 *
 * @method $this setCardHolder($value) Set Full name of customer as printed on credit card
 * @method $this setCardNumber($value) Set Complete CC number of customer
 * @method $this setCvv($value) Set CVV of CC, requirement is based on terminal configuration
 * @method bool getClientSideEncryption() Get Client-Side Encryption value
 */
trait CreditCardAttributes
{
    use BirthDateAttributes;

    /**
     * Full name of customer as printed on credit card (first name and last name at least)
     *
     * @var string
     */
    protected $card_holder;

    /**
     * Complete CC number of customer
     *
     * @var int
     */
    protected $card_number;

    /**
     * CVV of CC, requirement is based on terminal configuration
     *
     * @var int
     */
    protected $cvv;

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
     * Internal attribute used for ignoring the Credit Card fields validations
     *
     * @var bool
     */
    protected $client_side_encryption = false;

    /**
     * Internal attribute used for ignoring the Credit Card fields validations
     *
     * @param $value
     *
     * @return $this
     */
    public function setClientSideEncryption($value)
    {
        $this->client_side_encryption = Common::toBoolean($value);

        return $this;
    }

    /**
     * Returns a list with CC Card Number, Expiration Month, Expiration Year Validators
     *
     * @return array
     */
    protected function getCCFieldValueFormatValidators()
    {
        return [
            'card_holder'      => $this->getCreditCardHolderValidator(),
            'card_number'      => $this->getCreditCardNumberValidator(),
            'expiration_month' => $this->getCreditCardExpMonthValidator(),
            'expiration_year'  => $this->getCreditCardExpYearValidator()
        ];
    }

    /**
     * Instance of CC Holder Validator
     *
     * @return RegexValidator
     */
    protected function getCreditCardHolderValidator()
    {
        return new RegexValidator(
            RegexValidator::PATTERN_CREDIT_CARD_HOLDER
        );
    }

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
     * Instance of CC CVV Format Validator
     *
     * @return RegexValidator
     */
    protected function getCreditCardCVVValidator()
    {
        return new RegexValidator(
            RegexValidator::PATTERN_CREDIT_CARD_CVV
        );
    }

    /**
     * Instance of CC Expiration Month Format Validator
     *
     * @return RegexValidator
     */
    protected function getCreditCardExpMonthValidator()
    {
        return new RegexValidator(
            RegexValidator::PATTERN_CREDIT_CARD_EXP_MONTH
        );
    }

    /**
     * Instance of CC Expiration Year Format Validator
     *
     * @return RegexValidator
     */
    protected function getCreditCardExpYearValidator()
    {
        return new RegexValidator(
            RegexValidator::PATTERN_CREDIT_CARD_EXP_YEAR
        );
    }

    protected function requiredCCFieldsConditional()
    {
        return [
            'card_number' => [
                'expiration_month',
                'expiration_year'
            ]
        ];
    }

    protected function getCCAttributesStructure()
    {
        return [
            'card_holder'      => $this->card_holder,
            'card_number'      => $this->card_number,
            'expiration_month' => $this->expiration_month,
            'expiration_year'  => $this->expiration_year,
            'cvv'              => $this->cvv,
            'birth_date'       => $this->getBirthDate()
        ];
    }

    protected function removeCreditCardValidations()
    {
        if ($this->client_side_encryption) {
            $this->requiredFieldValues = CommonUtils::removeMultipleKeys(
                array_keys($this->getCCFieldValueFormatValidators()),
                $this->requiredFieldValues
            );
        }
    }
}
