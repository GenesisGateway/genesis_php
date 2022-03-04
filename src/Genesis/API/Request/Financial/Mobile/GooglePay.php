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

namespace Genesis\API\Request\Financial\Mobile;

use Genesis\API\Constants\Transaction\Parameters\Mobile\GooglePay\PaymentTypes as GooglePaySubtypes;
use Genesis\API\Constants\Transaction\Types as TransactionType;
use Genesis\API\Request\Base\Financial;
use Genesis\API\Traits\Request\DocumentAttributes;
use Genesis\API\Traits\Request\Financial\BirthDateAttributes;
use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\Business\BusinessAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\Mobile\GooglePayAttributes;
use Genesis\API\Traits\RestrictedSetter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Currency;

/**
 * Class GooglePay
 *
 * Google pay Request
 *
 * @package Genesis\API\Request\Financial\Mobile\GooglePay
 */
class GooglePay extends Financial
{
    use AddressInfoAttributes, PaymentAttributes, GooglePayAttributes, RestrictedSetter,
        BirthDateAttributes, BusinessAttributes, DocumentAttributes;

    /**
     * Used in Google token for signatures array
     */
    const GOOGLE_PAY_TOKEN_KEY_SIGNATURES = 'signatures';

    /**
     * Sets GooglePay token
     *
     * @param string $token
     * @return $this
     * @throws InvalidArgument
     */
    public function setJsonToken($token)
    {
        $tokenAttributes = CommonUtils::decodeJsonString($token, true);
        $this->recursiveIterator($tokenAttributes);

        return $this;
    }

    /**
     * Returns the Request transaction type
     *
     * @return string
     */
    protected function getTransactionType()
    {
        return TransactionType::GOOGLE_PAY;
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_id',
            'payment_subtype',
            'amount',
            'currency',
            'token_signature',
            'token_signed_key',
            'token_signatures',
            'token_protocol_version',
            'token_signed_message',
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'currency'        => Currency::getList(),
            'payment_subtype' => GooglePaySubtypes::getAllowedPaymentTypes(),
        ];
        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }

    /**
     * Return additional request attributes
     *
     * @return array
     */
    public function getPaymentTransactionStructure()
    {
        return [
            'usage'               => $this->usage,
            'amount'              => $this->transformAmount($this->amount, $this->currency),
            'currency'            => $this->currency,
            'remote_ip'           => $this->remote_ip,
            'payment_subtype'     => $this->payment_subtype,
            'payment_token'       => $this->getPaymentTokenStructure(),
            'customer_email'      => $this->customer_email,
            'customer_phone'      => $this->customer_phone,
            'birth_date'          => $this->getBirthDate(),
            'billing_address'     => $this->getBillingAddressParamsStructure(),
            'shipping_address'    => $this->getShippingAddressParamsStructure(),
            'business_attributes' => $this->getBusinessAttributesStructure(),
            'document_id'         => $this->document_id,
        ];
    }

    /**
     * Recursively walk token attributes and set local properties
     *
     * @param array $tokenAttributes
     * @return void
     */
    private function recursiveIterator($tokenAttributes)
    {
        foreach ($tokenAttributes as $attributeKey => $attributeValue) {
            if ($attributeKey === self::GOOGLE_PAY_TOKEN_KEY_SIGNATURES) {
                $this->setTokenSignatures($attributeValue);

                continue;
            }

            $property = 'token_' . CommonUtils::pascalToSnakeCase($attributeKey);
            if (property_exists($this, $property)) {
                $this->{'set' . CommonUtils::snakeCaseToCamelCase($property)}($attributeValue);
            }

            if (CommonUtils::isValidArray($attributeValue)) {
                $this->recursiveIterator($attributeValue);
            }
        }
    }
}
