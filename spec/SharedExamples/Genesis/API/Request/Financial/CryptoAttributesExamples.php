<?php

namespace spec\SharedExamples\Genesis\API\Request\Financial;

/**
 * Trait CryptoAttributesExamples
 * @package spec\SharedExamples\Genesis\API\Request\Financial
 */
trait CryptoAttributesExamples
{
    public function it_should_contain_crypto_attribute_into_request_structure()
    {
        $this->setRequestParameters();
        $this->setCrypto(true);

        $this->getDocument()->shouldContain('<crypto>true</crypto>');
    }
}
