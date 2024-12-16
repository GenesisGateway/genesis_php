<?php

namespace spec\Genesis\Api\Request\NonFinancial\Reconcile;

use Genesis\Api\Request\NonFinancial\Reconcile\Transaction;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\MissingTerminalTokenExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class TransactionSpec extends ObjectBehavior
{
    use MissingTerminalTokenExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Transaction::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->setTransactionId(null);
        $this->setArn(null);
        $this->setUniqueId(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_validate_with_arn()
    {
        $this->setArn($this->getFaker()->uuid);
        $this->getDocument()->shouldNotBeEmpty();
        $this->shouldNotThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_validate_with_transaction_id()
    {
        $this->setTransactionId($this->getFaker()->uuid);
        $this->getDocument()->shouldNotBeEmpty();
        $this->shouldNotThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_validate_with_unique_id()
    {
        $this->setUniqueId($this->getFaker()->uuid);
        $this->getDocument()->shouldNotBeEmpty();
        $this->shouldNotThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->uuid);
        $this->setArn($faker->uuid);
        $this->setUniqueId($faker->uuid);
    }
}
