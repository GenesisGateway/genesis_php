<?php

namespace spec\Genesis\API\Traits\Request\Financial\Threeds\V2;

use Genesis\Exceptions\InvalidMethod;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2\WpfAttributesStub;

/**
 * Class WpfAttributesSpec
 * @package spec\Genesis\API\Traits\Request\Financial\Threeds\V2
 */
class WpfAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(WpfAttributesStub::class);
    }

    public function it_should_return_params_structure()
    {
        $this->getStructure()->shouldBeArray();
        $this->getStructure()->shouldBeNotEmptyArray();
    }

    public function getMatchers()
    {
        return array(
            'beNotEmptyArray' => function ($subject) {
                return is_array($subject) && count($subject) > 0;
            }
        );
    }

    public function it_should_return_correct_structure()
    {
        $this->getStructure()->shouldHaveKeyWithValue(
            'control',
            [
                'challenge_window_size' => null,
                'challenge_indicator'   => null
            ]
        );
        $this->getStructure()->shouldHaveKeyWithValue(
            'purchase',
            [
                'category' => null
            ]
        );
        $this->getStructure()->shouldHaveKeyWithValue(
            'merchant_risk',
            [
                'shipping_indicator'           => null,
                'delivery_timeframe'           => null,
                'reorder_items_indicator'      => null,
                'pre_order_purchase_indicator' => null,
                'pre_order_date'               => null,
                'gift_card'                    => null,
                'gift_card_count'              => null
            ]
        );
        $this->getStructure()->shouldHaveKeyWithValue(
            'card_holder_account',
            [
                'creation_date'                       => null,
                'update_indicator'                    => null,
                'last_change_date'                    => null,
                'password_change_indicator'           => null,
                'password_change_date'                => null,
                'shipping_address_usage_indicator'    => null,
                'shipping_address_date_first_used'    => null,
                'transactions_activity_last_24_hours' => null,
                'transactions_activity_previous_year' => null,
                'provision_attempts_last_24_hours'    => null,
                'purchases_count_last_6_months'       => null,
                'suspicious_activity_indicator'       => null,
                'registration_indicator'              => null,
                'registration_date'                   => null
            ]
        );
        $this->getStructure()->shouldHaveKeyWithValue(
            'recurring',
            [
                'expiration_date' => null,
                'frequency'       => null
            ]
        );
    }

    public function it_should_not_allow_control_device_type()
    {
        $this->testInvalidMethod('ThreedsV2ControlDeviceType');
    }

    public function it_should_not_allow_sdk_interface()
    {
        $this->testInvalidMethod('ThreedsV2SdkInterface');
    }

    public function it_should_not_allow_sdk_max_timeout()
    {
        $this->testInvalidMethod('SdkMaxTimeout');
    }

    public function it_should_not_allow_sdk_ephemeral_public_key_pair()
    {
        $this->testInvalidMethod('SdkEphemeralPublicKeyPair');
    }

    public function it_should_not_allow_sdk_ui_types()
    {
        $this->testInvalidMethod('SdkUiTypes');
    }

    public function it_should_not_allow_sdk_application_id()
    {
        $this->testInvalidMethod('SdkApplicationId');
    }

    public function it_should_not_allow_sdk_encrypted_data()
    {
        $this->testInvalidMethod('SdkEncryptedData');
    }

    public function it_should_not_allow_sdk_reference_number()
    {
        $this->testInvalidMethod('SdkReferenceNumber');
    }

    public function it_should_not_allow_browser_java_enabled()
    {
        $this->testInvalidMethod('BrowserJavaEnabled');
    }

    public function it_should_not_allow_browser_accept_header()
    {
        $this->testInvalidMethod('BrowserAcceptHeader');
    }

    public function it_should_not_allow_browser_color_depth()
    {
        $this->testInvalidMethod('BrowserColorDepth');
    }

    public function it_should_not_allow_browser_language()
    {
        $this->testInvalidMethod('BrowserLanguage');
    }

    public function it_should_not_allow_browser_screen_height()
    {
        $this->testInvalidMethod('BrowserScreenHeight');
    }

    public function it_should_not_allow_browser_time_zone_offset()
    {
        $this->testInvalidMethod('BrowserTimeZoneOffset');
    }

    public function it_should_not_allow_browser_screen_width()
    {
        $this->testInvalidMethod('BrowserScreenWidth');
    }

    public function it_should_not_allow_browser_user_agent()
    {
        $this->testInvalidMethod('BrowserUserAgent');
    }

    private function testInvalidMethod($method)
    {
        $this->shouldThrow(InvalidMethod::class)->during("get$method");
        $this->shouldThrow(InvalidMethod::class)->during(
            "set$method",
            ['value']
        );
    }
}
