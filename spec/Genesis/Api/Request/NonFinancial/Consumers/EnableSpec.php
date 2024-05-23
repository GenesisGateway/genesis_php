<?php

namespace spec\Genesis\Api\Request\NonFinancial\Consumers;

use Genesis\Api\Request\NonFinancial\Consumers\Enable;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class EnableSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Enable::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'email',
            'consumer_id'
        ]);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setEmail($faker->email);
        $this->setConsumerId(rand(1000, 9999));
    }
}
