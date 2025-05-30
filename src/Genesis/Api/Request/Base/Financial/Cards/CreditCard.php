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

namespace Genesis\Api\Request\Base\Financial\Cards;

use Genesis\Api\Request\Base\Financial;
use Genesis\Api\Traits\Request\CreditCardAttributes;
use Genesis\Api\Traits\Request\DocumentAttributes;
use Genesis\Api\Traits\Request\Financial\Cards\TokenizationParamsAttributes;
use Genesis\Api\Traits\Request\Financial\CredentialOnFileAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Api\Traits\Request\TokenizationAttributes;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Currency;

/**
 * Class CreditCard
 *
 * @method bool getSchemeTokenized() Get the scheme tokenized
 *
 * @package Genesis\Api\Request\Base\Financial\Cards
 */
abstract class CreditCard extends Financial
{
    use CredentialOnFileAttributes;
    use CreditCardAttributes;
    use DocumentAttributes;
    use PaymentAttributes;
    use TokenizationAttributes;
    use TokenizationParamsAttributes;

    const REQUEST_KEY_AMOUNT = 'amount';

    /**
     * Required when the card_number is DPAN instead of Funding Primary Account Number,
     * see Tokenized e-commerce for details
     *
     * @var bool
     */
    protected $scheme_tokenized;

    /**
     * Set Scheme tokenized value
     *
     * @param bool $value
     *
     * @return $this
     */
    public function setSchemeTokenized($value)
    {
        $this->scheme_tokenized = CommonUtils::toBoolean($value);

        return $this;
    }

    /**
     * Return additional request attributes
     * @return array
     */
    abstract protected function getTransactionAttributes();

    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_id',
            'amount',
            'currency',
            'card_holder'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldsOR = [
            'card_number',
            'token'
        ];

        $this->requiredFieldsOR = CommonUtils::createArrayObject($requiredFieldsOR);

        $requiredFieldValues = [
             'currency'    => Currency::getList(),
        ];

        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }

    /**
     * Inject the requiredFieldValuesConditional Validations
     * Enable CC holder name validation if Client-Side Encryption is not set
     * Add document_id conditional validation if it is present
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     * @throws \Genesis\Exceptions\InvalidArgument
     * @throws \Genesis\Exceptions\InvalidClassMethod
     */
    protected function checkRequirements()
    {
        if (!$this->client_side_encryption) {
            $this->requiredFieldValues->card_holder = $this->getCreditCardHolderValidator();
        }

        $requiredFieldValuesConditional = $this->setRequiredCCFieldsConditionalValues();
        $this->requiredFieldValuesConditional = (empty($this->requiredFieldValuesConditional)) ?
            $this->requiredFieldValuesConditional = CommonUtils::createArrayObject($requiredFieldValuesConditional) :
            CommonUtils::createArrayObject(
                array_merge((array) $this->requiredFieldValuesConditional, $requiredFieldValuesConditional)
            );

        if ($this->document_id) {
            $this->requiredFieldValuesConditional = CommonUtils::createArrayObject(
                array_merge(
                    (array) $this->requiredFieldValuesConditional,
                    $this->getDocumentIdConditions()
                )
            );
        }

        parent::checkRequirements();
    }

    /**
     * Credit Card Validations
     * Disable validation if Client-Side Encryption is used
     *
     * @return array
     */
    protected function setRequiredCCFieldsConditionalValues()
    {
        return $this->client_side_encryption ? [] :
        [
            'card_number' => [
                $this->card_number => [
                    ['card_number' => $this->getCreditCardNumberValidator()]
                ]
            ],
            'expiration_month' => [
                $this->expiration_month => [
                    ['expiration_month' => $this->getCreditCardExpMonthValidator()]
                ]
            ],
            'expiration_year' => [
                $this->expiration_year => [
                    ['expiration_year' => $this->getCreditCardExpYearValidator()]
                ]
            ]
        ];
    }

    protected function getPaymentTransactionStructure()
    {
        return [
            $this->getCCAttributesStructure(),
            $this->getTokenizationStructure(),
            $this->getPaymentAttributesStructure(),
            $this->getTransactionAttributes(),
            $this->getCredentialOnFileAttributesStructure(),
            'scheme_tokenized'    => $this->scheme_tokenized,
            'tokenization_params' => $this->tokenizationParamsAttributesStructure(),
        ];
    }

    protected function requiredTokenizationFieldsConditional()
    {
        return [
            'token'         => [
                'consumer_id',
                'customer_email'
            ],
            'remember_card' => [
                true => [
                    'customer_email',
                    'card_number'
                ]
            ],
            'consumer_id'  => [
                'customer_email'
            ]
        ];
    }
}
