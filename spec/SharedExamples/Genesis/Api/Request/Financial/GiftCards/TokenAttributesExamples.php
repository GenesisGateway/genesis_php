<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial\GiftCards;

use spec\SharedExamples\Faker;

trait TokenAttributesExamples
{
    public function it_should_contain_token_when_set()
    {
        $this->setRequestParameters();

        $token = Faker::getInstance()->uuid();
        $this->setToken($token);

        $this->shouldNotThrow()->during('getDocument');
        $this->getDocument()->shouldContain("<token>{$token}</token>");
    }
}
