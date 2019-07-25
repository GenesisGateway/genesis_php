<?php

namespace spec\Genesis\API\Request\NonFinancial\Consumers;

use Genesis\API\Request\NonFinancial\Consumers\Retrieve;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class RetrieveSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Retrieve::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->setEmail(null);
        $this->setConsumerId(null);
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setEmail($faker->email);
        $this->setConsumerId(rand(1000, 9999));
    }
}
