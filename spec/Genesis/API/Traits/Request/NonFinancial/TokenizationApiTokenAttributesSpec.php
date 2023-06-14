<?php

namespace spec\Genesis\API\Traits\Request\NonFinancial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\NonFinancial\TokenizationApiTokenAttributesStub;
use spec\SharedExamples\Faker;
use Genesis\Exceptions\InvalidArgument;

class TokenizationApiTokenAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(TokenizationApiTokenAttributesStub::class);
    }

    public function it_should_set_token_correctly()
    {
        $token = Faker::getInstance()->uuid();

        $this->shouldNotThrow()->during(
            'setToken',
            [$token]
        );

        $this->getToken()->shouldBe($token);
    }

    public function it_should_fail_with_invalid_token()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setToken',
            [str_repeat('a', 35)]
        );

        $this->shouldThrow(InvalidArgument::class)->during(
            'setToken',
            [str_repeat('a', 37)]
        );
    }
}
