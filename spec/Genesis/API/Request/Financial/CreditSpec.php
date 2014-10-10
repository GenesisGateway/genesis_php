<?php

namespace spec\Genesis\API\Request\Financial;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreditSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\Credit');
    }

    function it_can_build_stucture()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\BlankRequiredField')->duringGetDocument();
    }

    function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $this->setTransactionId(mt_rand(PHP_INT_SIZE, PHP_INT_MAX));
        $this->setCurrency('USD');
        $this->setAmount(mt_rand(100, 100000));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setReferenceId(mt_rand(0, PHP_INT_MAX));
    }

    public function getMatchers()
    {
        return array(
            'beEmpty' => function($subject) {
                    return empty($subject);
                },
        );
    }
}
