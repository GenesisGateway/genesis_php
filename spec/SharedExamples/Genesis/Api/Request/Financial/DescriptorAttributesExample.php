<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Exceptions\InvalidArgument;
use spec\SharedExamples\Faker;

trait DescriptorAttributesExample
{
    public function it_should_contain_dynamic_descriptor_key()
    {
        $this->setRequestParameters();
        $this->setDynamicMerchantName('Merchant123');
        $this->getDocument()->shouldContain('dynamic_descriptor_params');
    }

    //check if params exist and they're correct
    public function it_should_contain_optional_dynamic_descriptor_params()
    {
        $this->setRequestParameters();
        // variables
        $testName = str_ireplace(" ", "\x20", Faker::getInstance()->name());
        $testCity = str_ireplace(" ", "\x20", Faker::getInstance()->city());
        $testMerchantId = Faker::getInstance()->uuid();

        $this->setDynamicMerchantCity($testCity);
        $this->setDynamicMerchantName($testName);
        $this->setDynamicSubMerchantId($testMerchantId);

        $testString = "\x20\x20<dynamic_descriptor_params>";
        $testString .= "\n\x20\x20\x20\x20<merchant_name>$testName</merchant_name>";
        $testString .= "\n\x20\x20\x20\x20<merchant_city>$testCity</merchant_city>";
        $testString .= "\n\x20\x20\x20\x20<sub_merchant_id>$testMerchantId</sub_merchant_id>";
        $testString .= "\n\x20\x20</dynamic_descriptor_params>";

        $this->getDocument()->shouldContain($testString);
    }

    // without dynamic descriptor
    public function it_should_not_contain_optional_dynamic_descriptor_params()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotContain("<dynamic_descriptor_params>");
    }

    public function it_should_contain_dynamic_descriptor_merchant_geo_coordinates()
    {
        $this->setRequestParameters();
        $this->setDynamicMerchantGeoCoordinates('40.73061,-73.93524');
        $this->getDocument()->shouldContain('merchant_geo_coordinates');
    }

    public function it_should_contain_dynamic_descriptor_merchant_service_geo_coordinates()
    {
        $this->setRequestParameters();
        $this->setDynamicMerchantServiceGeoCoordinates('40.73061,-73.93524');
        $this->getDocument()->shouldContain('merchant_service_geo_coordinates');
    }

    public function it_should_throw_when_dynamic_descriptor_merchant_geo_coordinates_is_invalid()
    {
        $this->setRequestParameters();
        $this->shouldThrow(InvalidArgument::class)->during(
            'setDynamicMerchantGeoCoordinates',
            ['12345678901234567890123']
        );
    }

    public function it_should_throw_when_dynamic_descriptor_merchant_service_geo_coordinates_is_invalid()
    {
        $this->setRequestParameters();
        $this->shouldThrow(InvalidArgument::class)->during(
            'setDynamicMerchantServiceGeoCoordinates',
            ['12345678901234567890123']
        );
    }
}
