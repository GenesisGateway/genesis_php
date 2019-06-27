<?php

namespace spec\Genesis\API\Request\NonFinancial\KYC\Transaction;

use Genesis\API\Request\NonFinancial\KYC\Transaction\Update;
use PhpSpec\ObjectBehavior;

class UpdateSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Update::class);
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

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setTransactionUniqueId(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_reason_with_special_states()
    {
        $this->setRequestParameters();

        $this->setStatus(Update::TRANSACTION_STATUS_REJECTED);
        $this->shouldThrow()->during('getDocument');

        $this->setStatus(Update::TRANSACTION_STATUS_DECLINED);
        $this->shouldThrow()->during('getDocument');

        $this->setStatus(Update::TRANSACTION_STATUS_CHARGEBACK);
        $this->shouldThrow()->during('getDocument');

        $this->setStatus(Update::TRANSACTION_STATUS_REFUND);
        $this->shouldThrow()->during('getDocument');

        $this->setStatus(Update::TRANSACTION_STATUS_RETURN);
        $this->shouldThrow()->during('getDocument');

        $this->setStatus(Update::TRANSACTION_STATUS_VOID);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_work_when_reason_set_with_special_states()
    {
        $this->setRequestParameters();
        $this->setReason('test');

        $this->setStatus(Update::TRANSACTION_STATUS_REJECTED);
        $this->shouldNotThrow()->during('getDocument');

        $this->setStatus(Update::TRANSACTION_STATUS_DECLINED);
        $this->shouldNotThrow()->during('getDocument');

        $this->setStatus(Update::TRANSACTION_STATUS_CHARGEBACK);
        $this->shouldNotThrow()->during('getDocument');

        $this->setStatus(Update::TRANSACTION_STATUS_REFUND);
        $this->shouldNotThrow()->during('getDocument');

        $this->setStatus(Update::TRANSACTION_STATUS_RETURN);
        $this->shouldNotThrow()->during('getDocument');

        $this->setStatus(Update::TRANSACTION_STATUS_VOID);
        $this->shouldNotThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $this->setTransactionUniqueId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setStatus(Update::TRANSACTION_STATUS_APPROVED);
    }

    public function getMatchers()
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            }
        );
    }
}
