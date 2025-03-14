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

namespace Genesis\Api\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Sdk\Interfaces;
use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Sdk\UiTypes;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait Sdk
 * @package Genesis\Api\Traits\Request\Financial\Threeds\V2
 *
 * @codingStandardsIgnoreStart
 * @method string getThreedsV2SdkInterface()              SDK Interface types that the device of the consumer supports for displaying specific challenge interfaces within the SDK
 * @method $this  setThreedsV2SdkInterface($value)        SDK Interface types that the device of the consumer supports for displaying specific challenge interfaces within the SDK
 * @method array  getThreedsV2SdkUiTypes()                UI type that the device of the consumer supports for displaying specific challenge interface
 * @method int    getThreedsV2SdkApplicationId()          Universally unique ID created upon all installations and updates of the 3DS Requester APP on a Customer Device
 * @method string getThreedsV2SdkEncryptedData()          JWE Object as defined Section 6.2.2.1 containing data encrypted by the SDK for the DS to decrypt
 * @method string getThreedsV2SdkEphemeralPublicKeyPair() Public key component of the ephemeral key pair generated by the 3DS SDK and used to establish session keys between the 3DS SDK and ACS
 * @method int    getThreedsV2SdkMaxTimeout()             Indicates the maximum amount of time (in minutes) for all exchanges
 * @method string getThreedsV2SdkReferenceNumber()        Identifies the vendor and version of the 3DS SDK that is integrated in a 3DS Requester App, assigned by EMVCo when the 3DS SDK is approved
 * @codingStandardsIgnoreEnd
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
trait Sdk
{
    /**
     * SDK Interface types that the device of the consumer supports for
     * displaying specific challenge interfaces within the SDK
     *
     * @var string $threeds_v2_sdk_interface
     */
    protected $threeds_v2_sdk_interface;

    /**
     * UI type that the device of the consumer supports for displaying specific challenge interface
     *
     * @var array $threeds_v2_sdk_ui_types
     */
    protected $threeds_v2_sdk_ui_types = [];

    /**
     * Universally unique ID created upon all installations and updates of the 3DS Requester APP on a Customer Device
     *
     * @var string $threeds_v2_sdk_application_id
     */
    protected $threeds_v2_sdk_application_id;

    /**
     * JWE Object as defined Section 6.2.2.1 containing data encrypted by the SDK for the DS to decrypt
     *
     * @var string $threeds_v2_sdk_encrypted_data
     */
    protected $threeds_v2_sdk_encrypted_data;

    /**
     * Public key component of the ephemeral key pair generated by the 3DS SDK and used to
     * establish session keys between the 3DS SDK and ACS
     *
     * @var string $threeds_v2_sdk_ephemeral_public_key_pair
     */
    protected $threeds_v2_sdk_ephemeral_public_key_pair;

    /**
     * Indicates the maximum amount of time (in minutes) for all exchanges
     *
     * @var int $threeds_v2_sdk_max_timeout
     */
    protected $threeds_v2_sdk_max_timeout;

    /**
     * Identifies the vendor and version of the 3DS SDK that is integrated in a 3DS Requester App,
     * assigned by EMVCo when the 3DS SDK is approved
     *
     * @var string $threeds_v2_sdk_reference_number
     */
    protected $threeds_v2_sdk_reference_number;

    /**
     * UI types that the device of the consumer supports for displaying specific challenge interface
     *
     * @param string|array $value
     * @return Sdk
     * @throws InvalidArgument
     */
    public function setThreedsV2SdkUiTypes($value)
    {
        $this->threeds_v2_sdk_ui_types = [];

        if (!is_array($value) && in_array($value, UiTypes::getAll(), true)) {
            $this->threeds_v2_sdk_ui_types = [$value];

            return $this;
        }

        if (is_array($value)) {
            foreach ($value as $type) {
                if (!in_array($type, UiTypes::getAll(), true)) {
                    throw new InvalidArgument(
                        'Invalid value/s given for threeds_v2_sdk_ui_types. Allowed: ' .
                        implode(', ', UiTypes::getAll())
                    );
                }

                array_push($this->threeds_v2_sdk_ui_types, $type);
            }

            return $this;
        }

        throw new InvalidArgument(
            'Invalid value/s given for threeds_v2_sdk_ui_types. Allowed: ' .
            implode(', ', UiTypes::getAll())
        );
    }

    /**
     * Universally unique ID created upon all installations and updates of the 3DS Requester APP on a Customer Device
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setThreedsV2SdkApplicationId($value)
    {
        return $this->setLimitedString(
            'threeds_v2_sdk_application_id',
            $value,
            null,
            36
        );
    }

    /**
     * JWE Object as defined Section 6.2.2.1 containing data encrypted by the SDK for the DS to decrypt
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setThreedsV2SdkEncryptedData($value)
    {
        return $this->setLimitedString(
            'threeds_v2_sdk_encrypted_data',
            $value,
            null,
            64000
        );
    }

    /**
     * Public key component of the ephemeral key pair generated by the 3DS SDK and used to
     * establish session keys between the 3DS SDK and ACS
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setThreedsV2SdkEphemeralPublicKeyPair($value)
    {
        return $this->setLimitedString(
            'threeds_v2_sdk_ephemeral_public_key_pair',
            $value,
            null,
            256
        );
    }

    /**
     * Indicates the maximum amount of time (in minutes) for all exchanges
     *
     * @param int $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setThreedsV2SdkMaxTimeout($value)
    {
        $this->threeds_v2_sdk_max_timeout = (int) $value;

        if ($this->threeds_v2_sdk_max_timeout < 5) {
            throw new InvalidArgument(
                'Invalid value specified, should be greater than or equal to 5.'
            );
        }

        return $this;
    }

    /**
     * Identifies the vendor and version of the 3DS SDK that is integrated in a 3DS Requester App,
     * assigned by EMVCo when the 3DS SDK is approved
     *
     * @param string $value
     * @return $this
     * @throws InvalidArgument
     */
    public function setThreedsV2SdkReferenceNumber($value)
    {
        return $this->setLimitedString(
            'threeds_v2_sdk_reference_number',
            $value,
            null,
            32
        );
    }

    /**
     * @return array
     */
    protected function getSdkValidations()
    {
        return [
            'threeds_v2_sdk_interface' => [
                $this->threeds_v2_sdk_interface => [
                    ['threeds_v2_sdk_interface' => Interfaces::getAll()]
                ]
            ]
        ];
    }

    /**
     * Return prepared structure used by the XML Builder
     *
     * @return array
     */
    private function getUiTypesXMLStructureDocument()
    {
        $data = [];

        // Transform the structure
        foreach ($this->threeds_v2_sdk_ui_types as $type) {
            array_push($data, ['ui_type' => $type]);
        }

        return $data;
    }

    /**
     * Get the SDK Attributes
     *
     * @return array
     */
    protected function getSdkAttributes()
    {
        return [
            'interface'                 => $this->getThreedsV2SdkInterface(),
            'ui_types'                  => $this->getUiTypesXMLStructureDocument(),
            'application_id'            => $this->getThreedsV2SdkApplicationId(),
            'encrypted_data'            => $this->getThreedsV2SdkEncryptedData(),
            'ephemeral_public_key_pair' => $this->getThreedsV2SdkEphemeralPublicKeyPair(),
            'max_timeout'               => $this->getThreedsV2SdkMaxTimeout(),
            'reference_number'          => $this->getThreedsV2SdkReferenceNumber()
        ];
    }
}
