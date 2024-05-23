<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial\Threeds\V2;

use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Sdk\UiTypes;
use Genesis\Api\Request\Financial\Cards\Authorize3D;
use Genesis\Api\Request\Financial\Cards\Recurring\InitRecurringSale3D;
use Genesis\Api\Request\Financial\Cards\Sale3D;
use Genesis\Api\Request\Wpf\Create as WpfCreate;
use Genesis\Config;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\Exception\Example\SkippingException;
use spec\Fixtures\Api\Stubs\Parser\ParserStub;
use spec\SharedExamples\Faker;


trait ThreedsV2AttributesExamples
{
    public function it_can_build_structure_with_3DSv2_attributes()
    {
        $this->setRequestParameters();
        $this->setThreedsV2Attributes();
        $this->setThreedsV2SdkAttributes();
        $this->setThreedsV2BrowserAttributes();

        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_contain_3ds_v2_nodes()
    {
        $this->setRequestParameters();
        $this->setThreedsV2Attributes();
        $this->setThreedsV2SdkAttributes();
        $this->setThreedsV2BrowserAttributes();

        $this->getDocument()->shouldContain('threeds_v2_params');
    }

    public function it_should_fail_without_browser_params()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException('Unsupported attributes from Web Payment Form');
        }

        $this->setRequestParameters();
        $this->setThreedsV2Attributes();
        $this->setThreedsV2SdkAttributes();

        $this->setThreedsV2ControlDeviceType('browser');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_without_sdk_params()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException('Unsupported attributes from Web Payment Form');
        }

        $this->setRequestParameters();
        $this->setThreedsV2Attributes();
        $this->setThreedsV2BrowserAttributes();

        $this->setThreedsV2ControlDeviceType('application');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_generate_signature_when_response_empty()
    {
        $this->shouldThrow(ErrorParameter::class)->during('generateThreedsV2Signature');
    }

    public function it_should_generate_correct_signature_from_response($response)
    {
        $this->prepareResponseMock($response);
        Config::setPassword('password_hash');

        $this->generateThreedsV2Signature()->shouldBe(
            '8adbf929910abae8467d09e8a369db8f889cbe5d16e9a154f6f452e48653f81'.
            '8ddb85426d970626b540d90d0e614f731e36b9ff5934d239399f26c605feecb07'
        );
    }

    public function it_should_fail_with_invalid_device_type()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException('Unsupported attributes from Web Payment Form');
        }

        $this->setFullThreedsV2Request();
        $this->setThreedsV2ControlDeviceType('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_challenge_window_size()
    {
        $this->setFullThreedsV2Request();
        $this->setThreedsV2ControlChallengeWindowSize('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_challenge_indicator()
    {
        $this->setFullThreedsV2Request();
        $this->setThreedsV2ControlChallengeIndicator('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_category()
    {
        $this->setFullThreedsV2Request();
        $this->setThreedsV2PurchaseCategory('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_shipping_indicator()
    {
        $this->setFullThreedsV2Request();
        $this->setThreedsV2MerchantRiskShippingIndicator('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_delivery_timeframe()
    {
        $this->setFullThreedsV2Request();
        $this->setThreedsV2MerchantRiskDeliveryTimeframe('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_reorder_items_indicator()
    {
        $this->setFullThreedsV2Request();
        $this->setThreedsV2MerchantRiskReorderItemsIndicator('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_pre_order_purchase_indicator()
    {
        $this->setFullThreedsV2Request();
        $this->setThreedsV2MerchantRiskPreOrderPurchaseIndicator('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_update_indicator()
    {
        $this->setFullThreedsV2Request();
        $this->setThreedsV2CardHolderAccountUpdateIndicator('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_password_change_indicator()
    {
        $this->setFullThreedsV2Request();
        $this->setThreedsV2CardHolderAccountPasswordChangeIndicator('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_shipping_address_usage_indicator()
    {
        $this->setFullThreedsV2Request();
        $this->setThreedsV2CardHolderAccountShippingAddressUsageIndicator('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_susspicious_activity_indicator()
    {
        $this->setFullThreedsV2Request();
        $this->setThreedsV2CardHolderAccountSuspiciousActivityIndicator('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_registration_indicator()
    {
        $this->setFullThreedsV2Request();
        $this->setThreedsV2CardHolderAccountRegistrationIndicator('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_interface()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException('Unsupported attributes from Web Payment Form');
        }

        $this->setFullThreedsV2Request();
        $this->setThreedsV2SdkInterface('invalid');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_have_valid_ui_types_xml_structure()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException('Unsupported attributes from Web Payment Form');
        }

        $this->setFullThreedsV2Request();

        $type_1 = Faker::getInstance()->randomElement(UiTypes::getAll());
        $type_2 = Faker::getInstance()->randomElement(UiTypes::getAll());
        $this->setThreedsV2SdkUiTypes([$type_1, $type_2]);

        $this->getDocument()->shouldContain(
             "\n\x20\x20\x20\x20\x20\x20<ui_types>" .
             "\n\x20\x20\x20\x20\x20\x20\x20\x20<ui_type>$type_1</ui_type>" .
             "\n\x20\x20\x20\x20\x20\x20\x20\x20<ui_type>$type_2</ui_type>" .
             "\n\x20\x20\x20\x20\x20\x20</ui_types>"
        );
    }

    public function it_should_fail_with_zero_or_negative_color_depth()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException('Unsupported attributes from Web Payment Form');
        }

        $this->setFullThreedsV2Request();

        $colorDepth = rand(PHP_INT_MIN, 0);
        $this->setThreedsV2BrowserColorDepth($colorDepth);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_pass_correct_java_enabled_attribute_in_the_structure()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException('Unsupported attributes from Web Payment Form');
        }

        $this->setFullThreedsV2Request();

        $this->setThreeDSV2BrowserJavaEnabled(false);

        $this->getDocument()->shouldContain('<java_enabled>false</java_enabled>');
    }

    public function it_should_allow_empty_integer_browser_time_zone_offset()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException('Unsupported attributes from Web Payment Form');
        }

        $this->setFullThreedsV2Request();
        $this->setThreedsV2BrowserTimeZoneOffset(0);

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_allow_empty_browser_string_time_zone_offset()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException('Unsupported attributes from Web Payment Form');
        }

        $this->setFullThreedsV2Request();
        $this->setThreedsV2BrowserTimeZoneOffset('0');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_contain_browser_time_zone_offset_when_zero_value()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException('Unsupported attributes from Web Payment Form');
        }

        $this->setFullThreedsV2Request();
        $this->setThreedsV2BrowserTimeZoneOffset(0);

        $this->getDocument()->shouldContain('<time_zone_offset>0</time_zone_offset>');
    }

    protected function prepareResponseMock($response)
    {
        $parser = new ParserStub('Financial\Threeds\V2');

        $response->beADoubleOf('Genesis\Api\Response');
        $response->getResponseObject()->willReturn(
            $parser->Transaction('xml', 'response')->getParsedDocument()
        );

        $this->response = $response;
    }

    protected function setFullThreedsV2Request()
    {
        $this->setRequestParameters();
        $this->setThreedsV2Attributes();
        $this->setThreedsV2BrowserAttributes();
        $this->setThreedsV2SdkAttributes();
    }

    protected function setThreedsV2Attributes()
    {
        $this->setThreedsV2MethodCallbackUrl('https://www.example.com/threeds/threeds_method/callback');

        if (!($this->getWrappedObject() instanceof WpfCreate)) {
            $this->setThreedsV2ControlDeviceType('browser');
        }

        $this->setThreedsV2ControlChallengeWindowSize('full_screen');
        $this->setThreedsV2ControlChallengeIndicator('preference');
        $this->setThreedsV2PurchaseCategory('service');
        $this->setThreedsV2MerchantRiskShippingIndicator('verified_address');
        $this->setThreedsV2MerchantRiskDeliveryTimeframe('electronic');
        $this->setThreedsV2MerchantRiskReorderItemsIndicator('reordered');
        $this->setThreedsV2MerchantRiskPreOrderPurchaseIndicator('merchandise_available');
        $this->setThreedsV2MerchantRiskPreOrderDate('16-10-2020');
        $this->setThreedsV2MerchantRiskGiftCard('on');
        $this->setThreedsV2MerchantRiskGiftCardCount(99);
        $this->setThreedsV2CardHolderAccountCreationDate('16-10-2019');
        $this->setThreedsV2CardHolderAccountUpdateIndicator('30_to_60_days');
        $this->setThreedsV2CardHolderAccountLastChangeDate('16-06-2020');
        $this->setThreedsV2CardHolderAccountPasswordChangeIndicator('no_change');
        $this->setThreedsV2CardHolderAccountPasswordChangeDate('01-09-2020');
        $this->setThreedsV2CardHolderAccountShippingAddressUsageIndicator('current_transaction');
        $this->setThreedsV2CardHolderAccountShippingAddressDateFirstUsed('11-09-2020');
        $this->setThreedsV2CardHolderAccountTransactionsActivityLast24Hours(2);
        $this->setThreedsV2CardHolderAccountTransactionsActivityPreviousYear(10);
        $this->setThreedsV2CardHolderAccountProvisionAttemptsLast24Hours(1);
        $this->setThreedsV2CardHolderAccountPurchasesCountLast6Months(5);
        $this->setThreedsV2CardHolderAccountSuspiciousActivityIndicator('no_suspicious_observed');
        $this->setThreedsV2CardHolderAccountRegistrationIndicator('30_to_60_days');
        $this->setThreedsV2CardHolderAccountRegistrationDate('16-09-2018');

        if ($this->getWrappedObject() instanceof InitRecurringSale3D ||
            $this->getWrappedObject() instanceof Sale3D ||
            $this->getWrappedObject() instanceof Authorize3D ||
            $this->getWrappedObject() instanceof WpfCreate
        ) {
            $this->setThreedsV2RecurringExpirationDate('12-12-2020');
            $this->setThreedsV2RecurringFrequency(2);
        }
    }

    protected function setThreedsV2BrowserAttributes()
    {
        // WPF request doesn't support Browser Attributes
        if ($this->getWrappedObject() instanceof WpfCreate) {
            return;
        }

        $this->setThreedsV2BrowserAcceptHeader('Exact content of the HTTP accept headers as sent to the 3DS Requester from the Cardholder browser');
        $this->setThreedsV2BrowserJavaEnabled('on');
        $this->setThreedsV2BrowserLanguage('en-GB');
        $this->setThreedsV2BrowserColorDepth(32);
        $this->setThreedsV2BrowserScreenHeight(900);
        $this->setThreedsV2BrowserScreenWidth(1440);
        $this->setThreedsV2BrowserTimeZoneOffset(-120);
        $this->setThreedsV2BrowserUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36');
    }

    protected function setThreedsV2SdkAttributes()
    {
        // WPF request doesn't support SDK Attributes
        if ($this->getWrappedObject() instanceof WpfCreate) {
            return;
        }

        $this->setThreedsV2SdkInterface('native');
        $this->setThreedsV2SdkUiTypes('multi_select');
        $this->setThreedsV2SdkApplicationId('fc1650c0-5778-0138-8205-2cbc32a32d65');
        $this->setThreedsV2SdkEncryptedData('encrypted-data-here');
        $this->setThreedsV2SdkEphemeralPublicKeyPair('public-key-pair');
        $this->setThreedsV2SdkMaxTimeout(10);
        $this->setThreedsV2SdkReferenceNumber('sdk-reference-number-her');
    }
}
