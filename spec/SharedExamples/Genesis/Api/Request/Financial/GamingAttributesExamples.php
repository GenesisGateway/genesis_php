<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

/**
 * Trait GamingAttributesExamples
 *
 * @package spec\SharedExamples\Genesis\Api\Request\Financial
 */
trait GamingAttributesExamples
{
    public function it_should_contain_gaming_attribute_into_request_structure()
    {
        $this->setRequestParameters();
        $this->setGaming(true);

        $this->getDocument()->shouldContain('<gaming>true</gaming>');
    }
}
