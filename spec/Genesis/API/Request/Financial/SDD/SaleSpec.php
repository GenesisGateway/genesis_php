<?php

namespace spec\Genesis\API\Request\Financial\SDD;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SaleSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\SDD\Sale');
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

    public function it_should_fail_when_missing_sdd_bank_parameters()
    {
        $this->setBaseRequestParameters();
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_iban_parameters()
    {
        $this->setRequestParameters();
        $this->setIban(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_amount_parameter()
    {
        $this->setRequestParameters();
        $this->setAmount(null);
        $this->shouldThrow()->during('getDocument');
    }

    protected function setBaseRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis Automated PHP Request');
        $this->setRemoteIp($faker->ipv4);

        $this->setCurrency('EUR');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));

        $this->setCustomerEmail($faker->email);

        $this->setBillingCountry($faker->countryCode);

        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
    }

    protected function setSDDRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setIban($faker->iban('DE'));
        $this->setBic('PBNKDEFFXXX');
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
    }

    protected function setRequestParameters()
    {
        $this->setBaseRequestParameters();
        $this->setSDDRequestParameters();
    }

    protected function getFaker()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\Payment($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        return $faker;
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