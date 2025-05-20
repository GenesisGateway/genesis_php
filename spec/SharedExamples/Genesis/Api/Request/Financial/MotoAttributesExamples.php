<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

/**
 * Trait MotoAttributesExamples
 *
 * @package spec\SharedExamples\Genesis\Api\Request\Financial
 */
trait MotoAttributesExamples
{
    public function it_should_contain_moto_attribute_into_request_structure()
    {
        $this->setRequestParameters();
        $this->setMoto(true);

        $this->getDocument()->shouldContain('<moto>true</moto>');
    }
}
