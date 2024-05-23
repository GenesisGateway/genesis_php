<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial;


use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\TokenizationApiAttributesStub;
use spec\SharedExamples\Faker;

class TokenizationApiAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(TokenizationApiAttributesStub::class);
    }

    public function it_should_set_consumer_id_correctly()
    {
        $consumer_id = Faker::getInstance()->randomNumber(5, true);

        $this->shouldNotThrow()->during(
            'setConsumerId',
            [$consumer_id]
        );

        $this->getConsumerId()->shouldBe($consumer_id);
    }

    public function it_should_fail_with_invalid_consumer_id()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setConsumerId',
            [str_repeat('7', 11)]
        );
    }

    public function it_should_set_email_correctly()
    {
        $email = Faker::getInstance()->email();

        $this->shouldNotThrow()->during(
            'setEmail',
            [$email]
        );

        $this->getEmail()->shouldBe($email);
    }

    public function it_should_fail_with_invalid_email()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setEmail',
            [234]
        );
    }

    public function it_should_set_token_type_correctly()
    {
        $token_type = 'uuid';

        $this->shouldNotThrow()->during(
            'setTokenType',
            [$token_type]
        );

        $this->getTokenType()->shouldBe($token_type);
    }
}
