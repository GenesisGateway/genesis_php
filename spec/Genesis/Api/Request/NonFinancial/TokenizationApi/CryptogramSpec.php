<?php

namespace spec\Genesis\Api\Request\NonFinancial\TokenizationApi;

use Genesis\Api\Request\NonFinancial\TokenizationApi\Cryptogram;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class CryptogramSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Cryptogram::class);
    }

    public function it_should_contain_required_parameters()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldContain('consumer_id');
        $this->getDocument()->shouldContain('token_type');
        $this->getDocument()->shouldContain('email');
        $this->getDocument()->shouldContain('token');
        $this->getDocument()->shouldContain('transaction_reference');
    }

    public function it_should_throw_when_email_invalid()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setEmail', ['invalid_email']);
    }

    public function it_should_fail_without_parameters()
    {
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_without_token()
    {
        $this->setRequestParameters();
        $this->setToken(null);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_without_transaction_reference()
    {
        $this->setRequestParameters();
        $this->setTransactionReference(null);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setConsumerId($faker->randomNumber(5));
        $this->setTokenType('uuid');
        $this->setEmail($faker->email());
        $this->setToken($faker->uuid());
        $this->setTransactionReference($faker->uuid());
    }
}
