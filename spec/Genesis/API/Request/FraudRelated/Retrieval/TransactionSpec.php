<?php

namespace spec\Genesis\API\Request\FraudRelated\Retrieval;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransactionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\FraudRelated\Retrieval\Transaction');
    }

    function it_can_build_stucture()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\BlankRequiredField')->duringgetDocument();
    }

    function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\Uuid($faker));

        $this->setOriginalTransactionUniqueId($faker->uuid);
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
