<?php

namespace spec\Genesis\API\Request\NonFinancial\Fraud\Retrieval;

use Genesis\API\Request\NonFinancial\Fraud\Retrieval\Transaction;
use PhpSpec\ObjectBehavior;
use Genesis\Exceptions\ErrorParameter;
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
