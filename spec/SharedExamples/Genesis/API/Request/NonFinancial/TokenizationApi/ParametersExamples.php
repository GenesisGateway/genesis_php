<?php

namespace spec\SharedExamples\Genesis\API\Request\NonFinancial\TokenizationApi;

/**
 * Trait ParametersExamples
 * @package spec\SharedExamples\Genesis\API\Request\NonFinancial\TokenizationApi
 */
trait ParametersExamples
{
    public function it_should_contain_required_parameters()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldContain('consumer_id');
        $this->getDocument()->shouldContain('token_type');
        $this->getDocument()->shouldContain('email');
        $this->getDocument()->shouldContain('token');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setConsumerId($faker->randomNumber(5));
        $this->setTokenType('uuid');
        $this->setEmail($faker->email());
        $this->setToken($faker->uuid());
    }
}
