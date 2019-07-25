<?php

namespace spec\Genesis\API\Request\NonFinancial\Fraud\Reports;

use Genesis\API\Request\NonFinancial\Fraud\Reports\Transaction;
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
            'original_transaction_unique_id'
        ]);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setOriginalTransactionUniqueId($faker->uuid);
    }
}
