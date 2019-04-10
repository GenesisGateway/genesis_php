<?php

namespace spec\Genesis\API\Request\NonFinancial\Consumers;

use PhpSpec\ObjectBehavior;

class RetrieveSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\NonFinancial\Consumers\Retrieve');
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

    public function it_should_fail_build_request_when_no_email()
    {
        $this->setRequestParameters();
        $this->setEmail(null);
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_build_request_when_no_consumer_id()
    {
        $this->setRequestParameters();
        $this->setConsumerId(null);
        $this->shouldNotThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $this->setEmail($faker->email);
        $this->setConsumerId(rand(1000, 9999));
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
