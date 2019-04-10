<?php

namespace spec\Genesis\API\Request\NonFinancial\Consumers;

use PhpSpec\ObjectBehavior;

class CreateSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\NonFinancial\Consumers\Create');
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setEmail(null);
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $this->setEmail($faker->email);
    }

    public function getMatchers()
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        );
    }
}
