<?php

namespace spec\Genesis\API\Request\NonFinancial\Fraud\Chargeback;

use Genesis\API\Request\NonFinancial\Fraud\Chargeback\Transaction;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class TransactionSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Transaction::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'arn'
        ]);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setArn($faker->uuid);
    }
}
