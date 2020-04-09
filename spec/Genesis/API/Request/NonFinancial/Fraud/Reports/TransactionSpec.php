<?php

namespace spec\Genesis\API\Request\NonFinancial\Fraud\Reports;

use Genesis\API\Request\NonFinancial\Fraud\Reports\Transaction;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Request\NonFinancial\Fraud\TransactionExample;

class TransactionSpec extends ObjectBehavior
{
    use RequestExamples, TransactionExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Transaction::class);
    }
}
