<?php

namespace spec\Genesis\API\Request\Financial\Wallets;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NetellerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\Wallets\Neteller');
    }

    public function it_can_build_stucture()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_customer_account_parameters()
    {
        $this->setRequestParameters();
        $this->setCustomerAccount(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_account_password_parameters()
    {
        $this->setRequestParameters();
        $this->setAccountPassword(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_billing_country_parameters()
    {
        $this->setRequestParameters();
        $this->setBillingCountry(null);
        $this->shouldThrow()->during('getDocument');
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

        $this->setUsage('Genesis Automated PHP Request');
        $this->setRemoteIp($faker->ipv4);

        $this->setCurrency('USD');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));

        $this->setCustomerEmail($faker->email);

        $this->setCustomerAccount($faker->uuid);

        $this->setAccountPassword($faker->realText());

        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);

        $this->setBillingCountry($faker->countryCode);
    }

    public function getMatchers()
    {
        return array(
            'beEmpty'       => function ($subject) {
                return empty($subject);
            },
            'contain'       => function ($subject, $arg) {
                return (stripos($subject, $arg) !== false);
            },
        );
    }
}
