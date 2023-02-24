<?php

namespace spec\Genesis\API\Request\NonFinancial\KYC\Transaction;

use Genesis\API\Constants\NonFinancial\KYC\TransactionStatuses;
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

        $this->setStatus(TransactionStatuses::REJECTED);
        $this->shouldThrow()->during('getDocument');

        $this->setStatus(TransactionStatuses::DECLINED);
        $this->shouldThrow()->during('getDocument');

        $this->setStatus(TransactionStatuses::CHARGEBACK);
        $this->shouldThrow()->during('getDocument');

        $this->setStatus(TransactionStatuses::REFUND);
        $this->shouldThrow()->during('getDocument');

        $this->setStatus(TransactionStatuses::RETURN);
        $this->shouldThrow()->during('getDocument');

        $this->setStatus(TransactionStatuses::VOID);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_work_when_reason_set_with_special_states()
    {
        $this->setRequestParameters();
        $this->setReason('test');

        $this->setStatus(TransactionStatuses::REJECTED);
        $this->shouldNotThrow()->during('getDocument');

        $this->setStatus(TransactionStatuses::DECLINED);
        $this->shouldNotThrow()->during('getDocument');

        $this->setStatus(TransactionStatuses::CHARGEBACK);
        $this->shouldNotThrow()->during('getDocument');

        $this->setStatus(TransactionStatuses::REFUND);
        $this->shouldNotThrow()->during('getDocument');

        $this->setStatus(TransactionStatuses::RETURN);
        $this->shouldNotThrow()->during('getDocument');

        $this->setStatus(TransactionStatuses::VOID);
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_have_correct_transaction_update_endpoint()
    {
        $this->getApiConfig('url')->shouldContain(
            'https://staging.kyc.emerchantpay.net:443/api/v1/update_transaction'
        );
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $this->setTransactionUniqueId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setStatus(TransactionStatuses::APPROVED);
    }

    public function getMatchers(): array
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            }
        );
    }
}
