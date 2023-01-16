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

namespace Genesis\API\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Control\DeviceTypes;
use Genesis\API\Response;
use Genesis\Config;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Currency;
use Genesis\Utils\Threeds\V2 as ThreedsV2Utils;

/**
 * Trait CommonAttributes
 * @package Genesis\API\Traits\Request\Financial\Threeds\V2
 */
trait CommonAttributes
{
    use Sdk, Browser, CardHolderAccount, MerchantRisk, Purchase, Control, Method;

    /**
     * Get the 3DSv2 Attributes Structure
     *
     * @return array
     */
    protected function getThreedsV2ParamsStructure()
    {
        return [
            'threeds_method'      => $this->getMethodAttributes(),
            'control'             => $this->getControlAttributes(),
            'purchase'            => $this->getPurchaseAttributes(),
            'merchant_risk'       => $this->getMerchantRiskAttributes(),
            'card_holder_account' => $this->getCardHolderAccountAttributes(),
            'browser'             => $this->getBrowserAttributes(),
            'sdk'                 => $this->getSdkAttributes()
        ];
    }

    /**
     * Generate the ThreedsV2Signature from the ResponseObject after Request Execution
     *
     * @return string
     * @throws ErrorParameter
     */
    public function generateThreedsV2Signature()
    {
        /** @var Response $response */
        $response = $this->getResponse();

        if (empty($response)) {
            throw new ErrorParameter(
                'Invalid Response. Try to execute() the Request first.'
            );
        }

        $responseObject = $response->getResponseObject();

        return ThreedsV2Utils::generateSignature(
            $responseObject->unique_id,
            Currency::amountToExponent($responseObject->amount, $responseObject->currency),
            $responseObject->timestamp->format(DateTimeFormat::YYYY_MM_DD_H_I_S_ZULU),
            Config::getPassword()
        );
    }

    /**
     * Return the Validation conditions for specific threeds_v2_control_device_type
     * * Browser - requires all Browser attributes
     * * Application - requires all SDK attributes
     *
     * @return array
     */
    protected function requiredThreedsV2DeviceTypeConditional()
    {
        return [
            'threeds_v2_control_device_type' => [
                DeviceTypes::BROWSER     => [
                    'threeds_v2_browser_accept_header',
                    'threeds_v2_browser_java_enabled',
                    'threeds_v2_browser_language',
                    'threeds_v2_browser_color_depth',
                    'threeds_v2_browser_screen_height',
                    'threeds_v2_browser_screen_width',
                    'threeds_v2_browser_time_zone_offset',
                    'threeds_v2_browser_user_agent'
                ],
                DeviceTypes::APPLICATION => [
                    'threeds_v2_sdk_interface',
                    'threeds_v2_sdk_ui_types',
                    'threeds_v2_sdk_application_id',
                    'threeds_v2_sdk_encrypted_data',
                    'threeds_v2_sdk_ephemeral_public_key_pair',
                    'threeds_v2_sdk_max_timeout',
                    'threeds_v2_sdk_reference_number'
                ]
            ]
        ];
    }

    /**
     * Get the ThreedsV2 Conditional Field Values Validations
     *
     * @return array
     */
    protected function getThreedsV2FieldValuesValidations()
    {
        return array_merge(
            $this->getControlValidations(),
            $this->getPurchaseValidations(),
            $this->getMerchantRiskValidations(),
            $this->getCardHolderAccountValidations(),
            $this->getBrowserValidations(),
            $this->getSdkValidations()
        );
    }
}
