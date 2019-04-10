<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking;

use Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking\Payin;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;

class PayinSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking\Payin');
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_amount_param()
    {
        $this->setRequestParameters();
        $this->setAmount(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_currency_param()
    {
        $this->setRequestParameters();
        $this->setCurrency(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_return_success_url_param()
    {
        $this->setRequestParameters();
        $this->setReturnSuccessUrl(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_return_failure_url_param()
    {
        $this->setRequestParameters();
        $this->setReturnFailureUrl(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_remote_ip_param()
    {
        $this->setRequestParameters();
        $this->setRemoteIp(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_wrong_currency_param()
    {
        $this->setRequestParameters();
        $this->setCurrency('USD');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_required_bank_code_is_missing()
    {
        $this->setRequestParameters();
        $this->setBankCode('');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_missing_billing_state_for_US_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('US');
        $this->setBillingState(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_billing_state_for_CA_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('CA');
        $this->setBillingState(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_invalid_payment_type_param()
    {
        $this->shouldThrow()->during('setPaymentType', ['fake_type']);
    }

    public function it_should_succeed_when_valid_payment_type_param()
    {
        $this->shouldNotThrow()->during('setPaymentType', [Payin::PAYMENT_TYPE_QR_PAYMENT]);
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\Payment($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setRemoteIp($faker->ipv4);
        $this->setCurrency('CNY');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setBankCode('GDB');
        $this->setCustomerEmail($faker->email);
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingAddress1($faker->streetAddress);
        $this->setBillingZipCode($faker->postcode);
        $this->setBillingCity($faker->city);
        $this->setBillingState($faker->state);
        $this->setBillingCountry($faker->countryCode);
    }

    public function getMatchers()
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        );
    }
}
