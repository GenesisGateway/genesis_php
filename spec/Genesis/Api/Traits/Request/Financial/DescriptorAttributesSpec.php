<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\DescriptorAttributesStub;
use spec\SharedExamples\Faker;

class DescriptorAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(DescriptorAttributesStub::class);
    }

    public function it_should_have_proper_structure()
    {
        $this->getStructure()->shouldBeArray();
    }

    public function it_should_include_merchant_name_with_proper_value_in_structure()
    {
        $merchant = Faker::getInstance()->firstName;

        $this->setDynamicMerchantName($merchant);

        $this->getStructure()->shouldHaveKeyWithValue('merchant_name', $merchant);
    }

    public function it_should_include_merchant_city_with_proper_value_in_structure()
    {
        $city = Faker::getInstance()->city;

        $this->setDynamicMerchantCity($city);

        $this->getStructure()->shouldHaveKeyWithValue('merchant_city', $city);
    }

    public function it_should_include_sub_merchant_id_with_proper_value_in_structure()
    {
        $merchantId = Faker::getInstance()->randomNumber(6, true);

        $this->setDynamicSubMerchantId($merchantId);

        $this->getStructure()->shouldHaveKeyWithValue('sub_merchant_id', $merchantId);
    }

    public function it_should_include_dynamic_merchant_country() {
        $country = Faker::getInstance()->country;

        $this->setDynamicMerchantCountry($country);

        $this->getStructure()->shouldHaveKeyWithValue('merchant_country', $country);
    }

    public function it_should_include_dynamic_merchant_state() {
        $state = Faker::getInstance()->state;

        $this->setDynamicMerchantState($state);

        $this->getStructure()->shouldHaveKeyWithValue('merchant_state', $state);
    }

    public function it_should_include_dynamic_merchant_zip_code() {
        $zip = Faker::getInstance()->postcode;

        $this->setDynamicMerchantZipCode($zip);

        $this->getStructure()->shouldHaveKeyWithValue('merchant_zip_code', $zip);
    }

    public function it_should_include_dynamic_merchant_address() {
        $address = Faker::getInstance()->address;

        $this->setDynamicMerchantAddress($address);

        $this->getStructure()->shouldHaveKeyWithValue('merchant_address', $address);
    }

    public function it_should_include_dynamic_merchant_url() {
        $url = Faker::getInstance()->url;

        $this->setDynamicMerchantUrl($url);

        $this->getStructure()->shouldHaveKeyWithValue('merchant_url', $url);
    }

    public function it_should_include_dynamic_merchant_phone() {
        $phone = Faker::getInstance()->phoneNumber;

        $this->setDynamicMerchantPhone($phone);

        $this->getStructure()->shouldHaveKeyWithValue('merchant_phone', $phone);
    }

    public function it_should_include_dynamic_merchant_service_city() {
        $city = Faker::getInstance()->city;

        $this->setDynamicMerchantServiceCity($city);

        $this->getStructure()->shouldHaveKeyWithValue('merchant_service_city', $city);
    }

    public function it_should_include_dynamic_merchant_service_country() {
        $country = Faker::getInstance()->country;

        $this->setDynamicMerchantServiceCountry($country);

        $this->getStructure()->shouldHaveKeyWithValue('merchant_service_country', $country);
    }

    public function it_should_include_dynamic_merchant_service_state() {
        $state = Faker::getInstance()->state;

        $this->setDynamicMerchantServiceState($state);

        $this->getStructure()->shouldHaveKeyWithValue('merchant_service_state', $state);
    }

    public function it_should_include_dynamic_merchant_service_zip_code() {
        $zip = Faker::getInstance()->postcode;

        $this->setDynamicMerchantServiceZipCode($zip);

        $this->getStructure()->shouldHaveKeyWithValue('merchant_service_zip_code', $zip);
    }

    public function it_should_include_dynamic_merchant_service_phone() {
        $phone = Faker::getInstance()->phoneNumber;

        $this->setDynamicMerchantServicePhone($phone);

        $this->getStructure()->shouldHaveKeyWithValue('merchant_service_phone', $phone);
    }
}
