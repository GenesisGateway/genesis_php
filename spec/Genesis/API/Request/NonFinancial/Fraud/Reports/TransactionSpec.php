<?php

namespace spec\Genesis\API\Request\NonFinancial\Fraud\Reports;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransactionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\NonFinancial\Fraud\Reports\Transaction');
    }

    function it_can_build_stucture()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setOriginalTransactionUniqueId(null);
        $this->shouldThrow()->during('getDocument');
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
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        );
    }
}
