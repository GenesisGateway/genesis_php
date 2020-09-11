<?php

namespace spec\SharedExamples\Genesis\API\Request\Financial\Business;

/**
 * Trait BusinessAttributesExample
 * @package spec\SharedExamples\Genesis\API\Request\Financial\Business
 */
trait BusinessAttributesExample
{
    public function it_should_contain_business_attributes_key()
    {
        $this->setRequestParameters();
        $this->setBusinessAirlineCode('123456789');

        $this->getDocument()->shouldContain('business_attributes');
    }
}
