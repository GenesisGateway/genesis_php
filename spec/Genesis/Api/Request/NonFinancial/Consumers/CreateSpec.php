<?php

namespace spec\Genesis\Api\Request\NonFinancial\Consumers;

use Genesis\Api\Request\NonFinancial\Consumers\Create;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class CreateSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Create::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'email'
        ]);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setEmail($faker->email);
    }
}
