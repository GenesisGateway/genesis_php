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
use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Control\DeviceTypes;

/**
 * Trait Control
 * @package Genesis\API\Traits\Request\Financial\Threeds\V2
 *
 * @method string getThreedsV2ControlDeviceType()                Identifies the device channel of the consumer
 * @method $this  setThreedsV2ControlDeviceType($value)          Identifies the device channel of the consumer
 * @codingStandardsIgnoreStart
 * @method string getThreedsV2ControlChallengeWindowSize()       Identifies the size of the challenge window for the consumer
 * @method $this  setThreedsV2ControlChallengeWindowSize($value) Identifies the size of the challenge window for the consumer
 * @method string getThreedsV2ControlChallengeIndicator()        The value has weight and might impact the decision whether a challenge will be required for the transaction or not
 * @method $this  setThreedsV2ControlChallengeIndicator($value)  The value has weight and might impact the decision whether a challenge will be required for the transaction or not
 * @codingStandardsIgnoreEnd
 */
trait Control
{
    /**
     * Identifies the device channel of the consumer
     *
     * @var string $threeds_v2_control_device_type
     */
    protected $threeds_v2_control_device_type;

    /**
     * @var string $threeds_v2_control_challenge_window_size
     */
    protected $threeds_v2_control_challenge_window_size;

    /**
     * @var string $threeds_v2_control_challenge_indicator
     */
    protected $threeds_v2_control_challenge_indicator;

    /**
     * Get the Control Attributes
     *
     * @return array
     */
    protected function getControlAttributes()
    {
        return [
            'device_type'           => $this->getThreedsV2ControlDeviceType(),
            'challenge_window_size' => $this->getThreedsV2ControlChallengeWindowSize(),
            'challenge_indicator'   => $this->getThreedsV2ControlChallengeIndicator()
        ];
    }

    /**
     * Validation conditions for Control params
     *
     * @return array
     */
    protected function getControlValidations()
    {
        return [
            'threeds_v2_control_device_type' => [
                $this->threeds_v2_control_device_type => [
                    ['threeds_v2_control_device_type' => DeviceTypes::getAll()]
                ]
            ],
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
}
