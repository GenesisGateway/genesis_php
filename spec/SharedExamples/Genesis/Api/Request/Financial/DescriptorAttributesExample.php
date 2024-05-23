<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

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
}
