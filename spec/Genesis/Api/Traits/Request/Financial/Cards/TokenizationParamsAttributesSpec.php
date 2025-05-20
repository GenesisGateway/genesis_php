<?php

namespace spec\Genesis\Api\Traits\Request\Financial\Cards;

use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\Cards\TokenizationParamsAttributesStub;

class TokenizationParamsAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(TokenizationParamsAttributesStub::class);
    }

    public function it_should_set_tavv()
    {
        $this->shouldNotThrow()->during('setTokenizationTavv', ['123456']);
    }

    public function it_should_set_eci()
    {
        $this->shouldNotThrow()->during('setTokenizationEci', ['01']);
    }

    public function it_should_fail_when_invalid_eci()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setTokenizationEci', ['123456']);
    }
}
