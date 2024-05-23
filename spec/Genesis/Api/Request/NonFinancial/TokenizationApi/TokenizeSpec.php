<?php

namespace spec\Genesis\Api\Request\NonFinancial\TokenizationApi;

use Genesis\Api\Request\NonFinancial\TokenizationApi\Tokenize;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\TokenizationApi\CreditCardSharedExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class TokenizeSpec extends ObjectBehavior
{
    use CreditCardSharedExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Tokenize::class);
    }

    public function it_should_contain_required_parameters()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldContain('consumer_id');
        $this->getDocument()->shouldContain('token_type');
        $this->getDocument()->shouldContain('email');
        $this->getDocument()->shouldContain('card_number');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setConsumerId($faker->randomNumber(5));
        $this->setTokenType('uuid');
        $this->setEmail($faker->email());
        $this->setCardNumber($faker->creditCardNumber());
    }
}
