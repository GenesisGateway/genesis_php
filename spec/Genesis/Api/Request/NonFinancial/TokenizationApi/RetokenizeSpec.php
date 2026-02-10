<?php

namespace spec\Genesis\Api\Request\NonFinancial\TokenizationApi;

use Genesis\Api\Request\NonFinancial\TokenizationApi\Retokenize;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\TokenizationApi\CreditCardSharedExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class RetokenizeSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Retokenize::class);
    }

    public function it_should_contain_required_parameters()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldContain('consumer_id');
        $this->getDocument()->shouldContain('token_type');
        $this->getDocument()->shouldContain('email');
        $this->getDocument()->shouldContain('token');
    }

    public function it_should_throw_when_token_not_valid()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setToken', [str_repeat('a', 50)]);
    }

    public function it_should_work_with_valid_token()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->during('setToken', [str_repeat('a', 36)]);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setConsumerId($faker->randomNumber(5));
        $this->setTokenType('uuid');
        $this->setToken($faker->uuid);
        $this->setEmail($faker->email());
    }
}
