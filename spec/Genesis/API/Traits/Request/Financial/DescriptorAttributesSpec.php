<?php

namespace spec\Genesis\API\Traits\Request\Financial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\DescriptorAttributesStub;

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
        $this->setDynamicMerchantName('merchant');

        $this->getStructure()->shouldHaveKeyWithValue('merchant_name', 'merchant');
    }

    public function it_should_include_merchant_city_with_proper_value_in_structure()
    {
        $this->setDynamicMerchantCity('Sofia');

        $this->getStructure()->shouldHaveKeyWithValue('merchant_city', 'Sofia');
    }

    public function it_should_include_sub_merchant_id_with_proper_value_in_structure()
    {
        $this->setDynamicSubMerchantId(123456);

        $this->getStructure()->shouldHaveKeyWithValue('sub_merchant_id', 123456);
    }
}
