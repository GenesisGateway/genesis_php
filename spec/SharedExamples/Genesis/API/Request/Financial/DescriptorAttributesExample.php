<?php

namespace spec\SharedExamples\Genesis\API\Request\Financial;

trait DescriptorAttributesExample
{
    public function it_should_contain_dynamic_descriptor_key()
    {
        $this->setRequestParameters();
        $this->setDynamicMerchantName('Merchant123');
        $this->getDocument()->shouldContain('dynamic_descriptor_params');
    }
}
