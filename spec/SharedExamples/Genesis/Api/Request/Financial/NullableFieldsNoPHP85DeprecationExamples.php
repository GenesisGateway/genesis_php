<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Api\Request\Wpf\Create as WpfCreate;
use PhpSpec\Exception\Example\SkippingException;

/**
 * Shared examples verifying that nullable optional fields used as array keys
 * do not trigger PHP 8.5 deprecation notices.
 *
 * The production code normalizes null to '' before using values as array keys.
 * These tests confirm that validation still works correctly when optional fields are unset.
 */
trait NullableFieldsNoPHP85DeprecationExamples
{
    public function it_should_not_fail_when_threeds_v2_purchase_category_is_not_set()
    {
        $this->setRequestParameters();
        $this->setThreedsV2BrowserAttributes();

        if (!($this->getWrappedObject() instanceof WpfCreate)) {
            $this->setThreedsV2ControlDeviceType('browser');
        }

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_threeds_v2_control_challenge_window_size_is_not_set()
    {
        $this->setRequestParameters();
        $this->setThreedsV2BrowserAttributes();

        if (!($this->getWrappedObject() instanceof WpfCreate)) {
            $this->setThreedsV2ControlDeviceType('browser');
        }

        $this->setThreedsV2ControlChallengeIndicator('preference');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_threeds_v2_control_challenge_indicator_is_not_set()
    {
        $this->setRequestParameters();
        $this->setThreedsV2BrowserAttributes();

        if (!($this->getWrappedObject() instanceof WpfCreate)) {
            $this->setThreedsV2ControlDeviceType('browser');
        }

        $this->setThreedsV2ControlChallengeWindowSize('full_screen');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_threeds_v2_control_device_type_is_not_set()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException('WPF does not use device_type attribute');
        }

        $this->setRequestParameters();
        $this->setThreedsV2BrowserAttributes();

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_threeds_v2_browser_color_depth_is_not_set()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException('WPF does not use browser attributes');
        }

        $this->setRequestParameters();

        // Do not set device_type to 'browser' so the browser-required validation does not fire.
        // This verifies the color_depth nullable key in the validation map is safely built.
        $this->setThreedsV2BrowserAcceptHeader('*/*');
        $this->setThreedsV2BrowserJavaEnabled('on');
        $this->setThreedsV2BrowserLanguage('en-GB');
        $this->setThreedsV2BrowserScreenHeight(900);
        $this->setThreedsV2BrowserScreenWidth(1440);
        $this->setThreedsV2BrowserTimeZoneOffset(-120);
        $this->setThreedsV2BrowserUserAgent('Mozilla/5.0');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_threeds_v2_sdk_interface_is_not_set()
    {
        if ($this->getWrappedObject() instanceof WpfCreate) {
            throw new SkippingException('WPF does not use SDK attributes');
        }

        $this->setRequestParameters();
        $this->setThreedsV2ControlDeviceType('browser');
        $this->setThreedsV2BrowserAttributes();

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_threeds_v2_merchant_risk_indicators_are_not_set()
    {
        $this->setRequestParameters();
        $this->setThreedsV2BrowserAttributes();

        if (!($this->getWrappedObject() instanceof WpfCreate)) {
            $this->setThreedsV2ControlDeviceType('browser');
        }

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_threeds_v2_card_holder_account_indicators_are_not_set()
    {
        $this->setRequestParameters();
        $this->setThreedsV2BrowserAttributes();

        if (!($this->getWrappedObject() instanceof WpfCreate)) {
            $this->setThreedsV2ControlDeviceType('browser');
        }

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_trigger_deprecation_when_threeds_v2_optional_fields_are_null()
    {
        $this->setRequestParameters();
        $this->setThreedsV2BrowserAttributes();

        if (!($this->getWrappedObject() instanceof WpfCreate)) {
            $this->setThreedsV2ControlDeviceType('browser');
        }

        $deprecations = array();
        set_error_handler(function ($errno, $errstr) use (&$deprecations) {
            $deprecations[] = $errstr;
        }, E_DEPRECATED | E_USER_DEPRECATED);

        $this->getWrappedObject()->getDocument();

        restore_error_handler();

        if (!empty($deprecations)) {
            throw new \Exception(
                'Deprecation notice triggered: ' . implode('; ', $deprecations)
            );
        }
    }

}
