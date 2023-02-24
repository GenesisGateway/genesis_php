<?php

namespace spec\Genesis\API\Request\NonFinancial\KYC\Transaction;

use Faker\Factory;
use Genesis\API\Constants\NonFinancial\KYC\PaymentMethods;
use Genesis\API\Request\NonFinancial\KYC\Transaction\Create;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;

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

    public function it_should_fail_when_wrong_transaction_created_at()
    {
        $this->setRequestParameters();
        $this->shouldThrow(InvalidArgument::class)->during('setTransactionCreatedAt', [date('Y-m-d')]);
    }

    public function it_should_not_fail_with_correct_transaction_created_at()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow(InvalidArgument::class)->during('setTransactionCreatedAt', [date('Y-m-d h:i:s')]);
    }

    public function it_should_fail_when_wrong_account()
    {
        $this->setRequestParameters();
        $this->shouldThrow(InvalidArgument::class)->during('setAccount', ['fail test']);
    }

    public function it_should_not_fail_with_correct_account()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow(InvalidArgument::class)->during('setAccount', ['8387428734']);
    }

    public function it_should_fail_when_missing_parameters_for_payment_method_echeck()
    {
        $this->setRequestParameters();
        $this->setPaymentMethod(PaymentMethods::ECHECK);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_not_fail_with_payment_method_echeck()
    {
        $this->setRequestParameters();
        $this->setPaymentMethod(PaymentMethods::ECHECK);
        $this->setEwalletId(null);
        $this->setRouting('88888');
        $this->setAccount('888888');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_parameters_for_payment_method_cc()
    {
        $this->setRequestParameters();
        $this->setPaymentMethod(PaymentMethods::CREDIT_CARD);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_not_fail_with_credit_card_payment_method()
    {
        $this->setRequestParameters();
        $this->setPaymentMethod(PaymentMethods::CREDIT_CARD);
        $this->setEwalletId(null);
        $this->setBin('411111');
        $this->setTail('1111');
        $this->setHashedPan(hash('sha256', 'test'));

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_set_correct_date_for_customer_registration_date()
    {
        $this->setRequestParameters();
        $dates = [
            Faker::getInstance()->date('Y-m-d'),
            Faker::getInstance()->date('d.m.Y')
        ];

        foreach ($dates as $date) {
            $this->shouldNotThrow()->during('setCustomerRegistrationDate', [$date]);
        }
    }

    public function it_should_not_fail_when_set_correct_date_for_first_deposit_date()
    {
        $this->setRequestParameters();
        $dates = [
            Faker::getInstance()->date('Y-m-d'),
            Faker::getInstance()->date('d.m.Y')
        ];

        foreach ($dates as $date) {
            $this->shouldNotThrow()->during('setFirstDepositDate', [$date]);
        }
    }

    public function it_should_not_fail_when_set_correct_date_for_first_withdrawal_date()
    {
        $this->setRequestParameters();
        $dates = [
            Faker::getInstance()->date('Y-m-d'),
            Faker::getInstance()->date('d.m.Y')
        ];

        foreach ($dates as $date) {
            $this->shouldNotThrow()->during('setFirstWithdrawalDate', [$date]);
        }
    }

    public function it_should_fail_when_invalid_date_for_customer_registration_date()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setCustomerRegistrationDate',
            [
                Faker::getInstance()->date('Ymd')
            ]
        );
    }

    public function it_should_fail_when_invalid_date_for_first_deposit_date()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setFirstDepositDate',
            [
                Faker::getInstance()->date('Ymd')
            ]
        );
    }

    public function it_should_fail_when_invalid_date_for_first_withdrawal_date()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setFirstWithdrawalDate',
            [
                Faker::getInstance()->date('Ymd')
            ]
        );
    }

    public function it_should_not_fail_with_correct_date_time_set_transaction_created_at()
    {
        $this->setRequestParameters();
        $dates = [
            Faker::getInstance()->date('Y-m-d H:i:s'),
            Faker::getInstance()->date('Y-m-d\TH:i:s\Z')
        ];

        foreach ($dates as $date) {
            $this->shouldNotThrow()->during('setTransactionCreatedAt', [$date]);
        }
    }

    public function it_should_not_fail_with_correct_date_time_set_local_time()
    {
        $this->setRequestParameters();
        $dates = [
            Faker::getInstance()->date('Y-m-d H:i:s'),
            Faker::getInstance()->date('Y-m-d\TH:i:s\Z')
        ];

        foreach ($dates as $date) {
            $this->shouldNotThrow()->during('setLocalTime', [$date]);
        }
    }

    public function it_should_fail_when_invalid_date_time_set_transaction_created_at()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setTransactionCreatedAt',
            [
                Faker::getInstance()->date('Ymd H:i:s')
            ]
        );
    }

    public function it_should_fail_when_invalid_date_time_set_local_time()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setLocalTime',
            [
                Faker::getInstance()->date('Ymd H:i:s'),
            ]
        );
    }

    public function it_should_return_string_when_get_local_time()
    {
        $this->setLocalTime(Faker::getInstance()->date('Y-m-d H:i:s'))
            ->getLocalTime()->shouldBeString();
    }

    public function it_should_return_string_when_get_transaction_created_at()
    {
        $this->setTransactionCreatedAt(Faker::getInstance()->date('Y-m-d H:i:s'))
            ->getTransactionCreatedAt()->shouldBeString();
    }

    public function it_should_return_string_when_get_customer_registration_date()
    {
        $this->setCustomerRegistrationDate(Faker::getInstance()->date('d.m.Y'))
            ->getCustomerRegistrationDate()->shouldBeString();
    }

    public function it_should_return_string_when_get_first_deposit_date()
    {
        $this->setFirstDepositDate(Faker::getInstance()->date('d.m.Y'))
            ->getFirstDepositDate()->shouldBeString();
    }

    public function it_should_return_string_when_get_first_withdrawal_date()
    {
        $this->setFirstWithdrawalDate(Faker::getInstance()->date('d.m.Y'))
            ->getFirstWithdrawalDate()->shouldBeString();
    }

    public function it_should_have_correct_transaction_create_endpoint()
    {
        $this->getApiConfig('url')->shouldContain(
            'https://staging.kyc.emerchantpay.net:443/api/v1/create_transaction'
        );
    }

    protected function setRequestParameters()
    {
        $faker = Factory::create();

        $this->setTransactionUniqueId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setTransactionCreatedAt($faker->date('Y-m-d H:i:s'));
        $this->setCustomerIpAddress($faker->ipv4);
        $this->setPaymentMethod(PaymentMethods::EWALLET);
        $this->setEwalletId($faker->email);
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
