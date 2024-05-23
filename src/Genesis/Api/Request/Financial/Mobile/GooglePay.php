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

namespace Genesis\Api\Request\Financial\Mobile;

use Genesis\Api\Constants\Transaction\Parameters\Mobile\GooglePay\PaymentTypes as GooglePaySubtypes;
use Genesis\Api\Constants\Transaction\Types as TransactionType;
use Genesis\Api\Request\Base\Financial;
use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\DocumentAttributes;
use Genesis\Api\Traits\Request\Financial\AsyncAttributes;
use Genesis\Api\Traits\Request\Financial\BirthDateAttributes;
use Genesis\Api\Traits\Request\Financial\Business\BusinessAttributes;
use Genesis\Api\Traits\Request\Financial\DescriptorAttributes;
use Genesis\Api\Traits\Request\Financial\NotificationAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Api\Traits\Request\Financial\Threeds\V2\AllAttributes as AllThreedsV2Attributes;
use Genesis\Api\Traits\Request\Mobile\GooglePayAttributes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;
use Genesis\Utils\Currency;

/**
 * Class GooglePay
 *
 * Google pay Request
 *
 * @package Genesis\Api\Request\Financial\Mobile\GooglePay
 */
class GooglePay extends Financial
{
    use AddressInfoAttributes;
    use AllThreedsV2Attributes;
    use AsyncAttributes;
    use BirthDateAttributes;
    use BusinessAttributes;
    use DescriptorAttributes;
    use DocumentAttributes;
    use GooglePayAttributes;
    use NotificationAttributes;
    use PaymentAttributes;

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

        $requiredFieldsConditional       = $this->requiredThreedsV2DeviceTypeConditional();
        $this->requiredFieldsConditional = CommonUtils::createArrayObject(
            $requiredFieldsConditional
        );
    }

    /**
     * Add document_id conditional validation if it is present
     *
     * @return void
     * @throws InvalidArgument
     * @throws \Genesis\Exceptions\ErrorParameter
     * @throws \Genesis\Exceptions\InvalidClassMethod
     */
    protected function checkRequirements()
    {
        $requiredFieldsValuesConditional = $this->getThreedsV2FieldValuesValidations();

        if ($this->document_id) {
            $requiredFieldsValuesConditional = array_merge_recursive(
                $requiredFieldsValuesConditional,
                $this->getDocumentIdConditions()
            );
        }

        $this->requiredFieldValuesConditional = CommonUtils::createArrayObject($requiredFieldsValuesConditional);

        parent::checkRequirements();
    }

    /**
     * Return additional request attributes
     *
     * @return array
     */
    public function getPaymentTransactionStructure()
    {
        return [
            'usage'                     => $this->usage,
            'amount'                    => $this->transformAmount($this->amount, $this->currency),
            'currency'                  => $this->currency,
            'remote_ip'                 => $this->remote_ip,
            'payment_subtype'           => $this->payment_subtype,
            'payment_token'             => $this->getPaymentTokenStructure(),
            'customer_email'            => $this->customer_email,
            'customer_phone'            => $this->customer_phone,
            'birth_date'                => $this->getBirthDate(),
            'notification_url'          => $this->notification_url,
            'return_success_url'        => $this->return_success_url,
            'return_failure_url'        => $this->return_failure_url,
            'billing_address'           => $this->getBillingAddressParamsStructure(),
            'shipping_address'          => $this->getShippingAddressParamsStructure(),
            'business_attributes'       => $this->getBusinessAttributesStructure(),
            'dynamic_descriptor_params' => $this->getDynamicDescriptorParamsStructure(),
            'document_id'               => $this->document_id,
            'threeds_v2_params'         => $this->getThreedsV2ParamsStructure(),
        ];
    }

    /**
     * Return the required parameters keys which values could evaluate as empty
     * Example value:
     * array(
     *     'class_property' => 'request_structure_key'
     * )
     *
     * @return array
     */
    protected function allowedEmptyNotNullFields()
    {
        return array(
                'threeds_v2_browser_time_zone_offset' => 'time_zone_offset'
        );
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
