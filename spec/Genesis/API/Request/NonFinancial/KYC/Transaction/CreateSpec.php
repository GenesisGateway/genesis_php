<?php

namespace spec\Genesis\API\Request\NonFinancial\KYC\Transaction;

use Genesis\API\Request\NonFinancial\KYC\Transaction\Create;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;

class CreateSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Create::class);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setTransactionUniqueId(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_with_wrong_transaction_created_at()
    {
        $this->setRequestParameters();
        $this->shouldThrow(InvalidArgument::class)->during('setTransactionCreatedAt', [date('Y-m-d')]);
    }

    public function it_should_work_with_correct_transaction_created_at()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow(InvalidArgument::class)->during('setTransactionCreatedAt', [date('Y-m-d h:i:s')]);
    }

    public function it_should_fail_with_wrong_account()
    {
        $this->setRequestParameters();
        $this->shouldThrow(InvalidArgument::class)->during('setAccount', ['fail test']);
    }

    public function it_should_work_with_correct_account()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow(InvalidArgument::class)->during('setAccount', ['8387428734']);
    }

    public function it_should_fail_when_missing_parameters_for_payment_method_echeck()
    {
        $this->setRequestParameters();
        $this->setPaymentMethod(Create::PAYMENT_METHOD_ECHECK);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_work_with_payment_method_echeck()
    {
        $this->setRequestParameters();
        $this->setPaymentMethod(Create::PAYMENT_METHOD_ECHECK);
        $this->setEwalletId(null);
        $this->setRouting('88888');
        $this->setAccount('888888');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_parameters_for_payment_method_cc()
    {
        $this->setRequestParameters();
        $this->setPaymentMethod(Create::PAYMENT_METHOD_CREDIT_CARD);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_work_with_payment_method_cc()
    {
        $this->setRequestParameters();
        $this->setPaymentMethod(Create::PAYMENT_METHOD_CREDIT_CARD);
        $this->setEwalletId(null);
        $this->setBin('411111');
        $this->setTail('1111');
        $this->setHashedPan(hash('sha256', 'test'));

        $this->shouldNotThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $this->setTransactionUniqueId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setTransactionCreatedAt(date('Y-m-d h:i:s'));
        $this->setCustomerIpAddress($faker->ipv4);
        $this->setPaymentMethod(Create::PAYMENT_METHOD_EWALLET);
        $this->setEwalletId($faker->email);
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
