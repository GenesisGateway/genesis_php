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

use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Control\ChallengeIndicators;
use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Control\ChallengeWindowSizes;
use Genesis\Exceptions\InvalidMethod;

/**
 * Trait WpfAttributes
 * Includes All Web Payment Form Threeds V2 Attributes
 *
 * @package Genesis\API\Traits\Request\Financial\Threeds\V2
 *
 * @SuppressWarnings("unused")
 */
trait WpfAttributes
{
    use Recurring, CommonAttributes;

    public function getThreedsV2ControlDeviceType()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2ControlDeviceType($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2SdkInterface()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2SdkInterface($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2SdkMaxTimeout()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2SdkMaxTimeout($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2SdkEphemeralPublicKeyPair()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2SdkEphemeralPublicKeyPair($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2SdkUiTypes()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2SdkUiTypes($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2SdkApplicationId()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2SdkApplicationId($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2SdkEncryptedData()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2SdkEncryptedData($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2SdkReferenceNumber()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2SdkReferenceNumber($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2BrowserJavaEnabled()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2BrowserJavaEnabled($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2BrowserAcceptHeader()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2BrowserAcceptHeader($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2BrowserColorDepth()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2BrowserColorDepth($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2BrowserLanguage()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2BrowserLanguage($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2BrowserScreenHeight()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2BrowserScreenHeight($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2BrowserTimeZoneOffset()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2BrowserTimeZoneOffset($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2BrowserScreenWidth()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2BrowserScreenWidth($value)
    {
        $this->throwMethodError(__METHOD__);
    }

    public function getThreedsV2BrowserUserAgent()
    {
        $this->throwMethodError(__METHOD__);
    }

    public function setThreedsV2BrowserUserAgent($value)
    {
        $this->throwMethodError(__METHOD__);
    }
    
    protected function getThreedsV2ParamsStructure()
    {
        return array_merge(
            [
                'control'             => $this->getControlAttributes(),
                'purchase'            => $this->getPurchaseAttributes(),
                'merchant_risk'       => $this->getMerchantRiskAttributes(),
                'card_holder_account' => $this->getCardHolderAccountAttributes(),
                'recurring'           => $this->getRecurringAttributes()
            ]
        );
    }

    /**
     * Get the Control Attributes for Request via Web Payment Form
     *
     * @return array
     */
    protected function getControlAttributes()
    {
        return [
            'challenge_window_size' => $this->getThreedsV2ControlChallengeWindowSize(),
            'challenge_indicator'   => $this->getThreedsV2ControlChallengeIndicator()
        ];
    }

    /**
     * Validation conditions for Control params via Web Payment Form
     *
     * @return array
     */
    protected function getControlValidations()
    {
        return [
            'threeds_v2_control_challenge_window_size' => [
                $this->threeds_v2_control_challenge_window_size => [
                    ['threeds_v2_control_challenge_window_size' => ChallengeWindowSizes::getAll()]
                ]
            ],
            'threeds_v2_control_challenge_indicator' => [
                $this->threeds_v2_control_challenge_indicator => [
                    ['threeds_v2_control_challenge_indicator' => ChallengeIndicators::getAll()]
                ]
            ]
        ];
    }

    private function throwMethodError($method)
    {
        throw new InvalidMethod(
            sprintf(
                'You\'re trying to call a non-existent method %s of class %s!',
                $method,
                static::class
            )
        );
    }
}
