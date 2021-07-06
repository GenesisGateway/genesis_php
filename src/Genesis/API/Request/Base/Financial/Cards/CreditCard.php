<?php
/*
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
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Request\Base\Financial\Cards;

use Genesis\API\Traits\Request\CreditCardAttributes;
use Genesis\API\Traits\Request\Financial\CredentialOnFileAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\TokenizationAttributes;
use Genesis\Utils\Common;

/**
 * Class CreditCard
 * @package Genesis\API\Request\Base\Financial\Cards
 *
 * @suppressWarnings(PHPMD.LongVariable)
 */
abstract class CreditCard extends \Genesis\API\Request\Base\Financial
{
    use CreditCardAttributes, TokenizationAttributes, PaymentAttributes, CredentialOnFileAttributes;

    const REQUEST_KEY_AMOUNT = 'amount';

    /**
     * Return additional request attributes
     * @return array
     */
    abstract protected function getTransactionAttributes();

    /**
     * Indicated if Zero amounts will be passed through Required field the validations
     *
     * @return bool
     */
    protected function allowedZeroAmount()
    {
        return false;
    }

    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_id',
            'amount',
            'currency',
            'card_holder'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldsOR = [
            'card_number',
            'token'
        ];

        $this->requiredFieldsOR = \Genesis\Utils\Common::createArrayObject($requiredFieldsOR);

        $requiredFieldValues = [
             'currency'    => \Genesis\Utils\Currency::getList(),
             'card_holder' => $this->getCreditCardHolderValidator()
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
    }

    /**
     * Inject the requiredFieldValuesConditional Validations
     *
     * @throws \Genesis\Exceptions\ErrorParameter
     * @throws \Genesis\Exceptions\InvalidArgument
     * @throws \Genesis\Exceptions\InvalidClassMethod
     */
    protected function checkRequirements()
    {
        $requiredFieldValuesConditional = $this->setRequiredCCFieldsConditionalValues();

        $this->requiredFieldValuesConditional = (empty($this->requiredFieldValuesConditional)) ?
            $this->requiredFieldValuesConditional = Common::createArrayObject($requiredFieldValuesConditional) :
            Common::createArrayObject(
                array_merge((array) $this->requiredFieldValuesConditional, $requiredFieldValuesConditional)
            );

        parent::checkRequirements();
    }

    /**
     * Credit Card Validations
     *
     * @return array
     */
    protected function setRequiredCCFieldsConditionalValues()
    {
        return [
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
        return array_merge(
            [
                $this->getCCAttributesStructure(),
                $this->getTokenizationStructure(),
                $this->getPaymentAttributesStructure(),
                $this->getTransactionAttributes(),
                $this->getCredentialOnFileAttributesStructure()
            ]
        );
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
