<?php

namespace spec\Genesis\API\Request\Financial\Wallets;

use PhpSpec\ObjectBehavior;

class ZimplerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\Wallets\Zimpler');
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

    public function it_should_fail_when_missing_return_success_url_parameter()
    {
        $this->setRequestParameters();
        $this->setReturnSuccessUrl(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_return_failure_url_parameter()
    {
        $this->setRequestParameters();
        $this->setReturnFailureUrl(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_amount_param()
    {
        $this->setRequestParameters();
        $this->setAmount(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_invalid_currency()
    {
        $this->setRequestParameters();
        $this->setCurrency('USD');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_invalid_country()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('BG');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_customer_email()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setCustomerEmail', ['null']);
    }

    public function it_should_set_billing_country_correctly()
    {
        $this->setRequestParameters();

        $this->setBillingCountry('FI');
        $this->shouldNotThrow()->during('getDocument');

        $this->setBillingCountry('SE');
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_set_currency_correctly()
    {
        $this->setRequestParameters();

        $this->setCurrency('EUR');
        $this->shouldNotThrow()->during('getDocument');

        $this->setCurrency('SEK');
        $this->shouldNotThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis Automated PHP Request');
        $this->setCurrency('EUR');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCustomerEmail($faker->email);
        $this->setCustomerPhone($faker->phoneNumber);
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setBillingCountry('FI');
    }

    protected function getFaker()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\Payment($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        return $faker;
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
