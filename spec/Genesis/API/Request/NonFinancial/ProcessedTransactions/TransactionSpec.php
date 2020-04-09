<?php

namespace spec\Genesis\API\Request\NonFinancial\ProcessedTransactions;

use Genesis\API\Request\NonFinancial\ProcessedTransactions\Transaction;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class TransactionSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Transaction::class);
    }

    public function it_should_fail_with_missing_required_parameter_unique_id()
    {
        $this->setRequestParameters();
        $this->setArn(null);

        $this->testMissingRequiredParameter('unique_id');
    }

    public function it_should_fail_with_missing_required_parameter_arn()
    {
        $this->setRequestParameters();
        $this->setUniqueId(null);

        $this->testMissingRequiredParameter('arn');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setArn($faker->uuid);
    }
}
