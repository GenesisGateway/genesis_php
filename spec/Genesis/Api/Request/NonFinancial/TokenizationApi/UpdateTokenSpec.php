<?php

namespace spec\Genesis\Api\Request\NonFinancial\TokenizationApi;

use Genesis\Api\Request\NonFinancial\TokenizationApi\UpdateToken;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\TokenizationApi\CreditCardSharedExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class UpdateTokenSpec extends ObjectBehavior
{
    use CreditCardSharedExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(UpdateToken::class);
    }

    public function it_should_contain_required_parameters()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldContain('consumer_id');
        $this->getDocument()->shouldContain('email');
        $this->getDocument()->shouldContain('token');
        $this->getDocument()->shouldContain('token_type');
        $this->getDocument()->shouldContain('card_number');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setConsumerId($faker->randomNumber(5));
        $this->setEmail($faker->email());
        $this->setToken($faker->uuid());
        $this->setTokenType('uuid');
        $this->setCardNumber($faker->creditCardNumber());
    }
}
