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

use Genesis\API\Traits\Request\DocumentAttributes;
use Genesis\API\Traits\Request\AddressInfoAttributes;
use Genesis\API\Traits\Request\Financial\BirthDateAttributes;
use Genesis\API\Traits\Request\Financial\CryptoAttributes;
use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\Mobile\ApplePayAttributes;
use Genesis\API\Constants\Transaction\Parameters\Mobile\ApplePayParameters;
use Genesis\API\Traits\RestrictedSetter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class ApplePay
 *
 * Apple pay Request
 *
 * @package Genesis\API\Request\Financial\Mobile\ApplePay
 */
class ApplePay extends \Genesis\API\Request\Base\Financial
{
    use AddressInfoAttributes, DocumentAttributes, PaymentAttributes, ApplePayAttributes,
        RestrictedSetter, CryptoAttributes, BirthDateAttributes;

    /**
     * Sets ApplePay token
     *
     * @param string $token
     * @return $this
     * @throws InvalidArgument
     */
    public function setJsonToken($token)
    {
        $tokenAttributes = CommonUtils::decodeJsonString($token, true);
        array_walk_recursive($tokenAttributes, function ($attributeValue, $attributeKey) {
            $property = 'token_' . CommonUtils::pascalToSnakeCase($attributeKey);
            if (property_exists($this, $property)) {
                $this->{'set' . CommonUtils::snakeCaseToCamelCase($property)}($attributeValue);
            }
        });

        return $this;
    }

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::APPLE_PAY;
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
            'payment_type',
            'token_version',
            'token_data',
            'token_signature',
            'token_ephemeral_public_key',
            'token_public_key_hash',
            'token_transaction_id',
            'token_display_name',
            'token_network',
            'token_type',
            'token_transaction_identifier',
            'amount',
            'currency'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues  = array_merge(
            [
                'currency'     => \Genesis\Utils\Currency::getList(),
                'payment_type' => ApplePayParameters::getAllowedPaymentTypes()
            ]
        );

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'usage'            => $this->usage,
            'amount'           => $this->transformAmount($this->amount, $this->currency),
            'currency'         => $this->currency,
            'remote_ip'        => $this->remote_ip,
            'payment_type'     => $this->payment_type,
            'payment_token'    => $this->getPaymentTokenStructure(),
            'customer_email'   => $this->customer_email,
            'customer_phone'   => $this->customer_phone,
            'birth_date'       => $this->getBirthDate(),
            'billing_address'  => $this->getBillingAddressParamsStructure(),
            'shipping_address' => $this->getShippingAddressParamsStructure(),
            'document_id'      => $this->document_id,
            'crypto'           => $this->crypto
        ];
    }
}
