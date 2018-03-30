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

namespace Genesis\API\Request\Base\Financial;

use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\Financial\DescriptorAttributes;
use Genesis\API\Traits\Request\Financial\ReferenceAttributes;
use Genesis\API\Validators\Request\RegexValidator;
use Genesis\Utils\Common;

/**
 * Class GiftCard
 * @package Genesis\API\Request\Base\Financial
 *
 * @method $this setCardNumber($value)
 * @method $this setCvv($value)
 */
abstract class GiftCard extends \Genesis\API\Request\Base\Financial
{
    use PaymentAttributes, AddressInfoAttributes, DescriptorAttributes, ReferenceAttributes;

    /**
     * Gift card number
     * @var string
     */
    protected $card_number;

    /**
     * Verification code for the gift card
     * @var string
     */
    protected $cvv;

    /**
     * Instance of GiftCard Number Format Validator
     *
     * @return RegexValidator
     */
    protected function getGiftCardNumberValidator()
    {
        return new RegexValidator(
            RegexValidator::PATTERN_GIFT_CARD_NUMBER
        );
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $this->requiredFields = Common::createArrayObject([
            'transaction_id',
            'amount',
            'currency',
            'card_number',
        ]);

        $this->requiredFieldValues = Common::createArrayObject([
            'currency'    => ['EUR', 'USD'],
            'card_number' => $this->getGiftCardNumberValidator()
        ]);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'amount'                    => $this->transformAmount($this->amount, $this->currency),
            'currency'                  => $this->currency,
            'card_number'               => $this->card_number,
            'cvv'                       => $this->cvv,
            'customer_email'            => $this->customer_email,
            'customer_phone'            => $this->customer_phone,
            'billing_address'           => $this->getBillingAddressParamsStructure(),
            'shipping_address'          => $this->getShippingAddressParamsStructure(),
            'dynamic_descriptor_params' => $this->getDynamicDescriptorParamsStructure(),
            'reference_id'              => $this->reference_id
        ];
    }
}
