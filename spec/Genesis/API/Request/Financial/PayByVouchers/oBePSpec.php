<?php

namespace spec\Genesis\API\Request\Financial\PayByVouchers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class oBePSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\PayByVouchers\oBeP');
    }

    function it_can_build_stucture()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow()->during('getDocument');
    }

    function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setCustomerName(null);
        $this->shouldThrow()->during('getDocument');
    }

    function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\Payment($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setRemoteIp($faker->ipv4);
        $this->setCurrency('USD');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));

        $this->setProductName('Paul Blart Mall Cop');
        $this->setProductCategory('movie');
        $this->setCustomerName('李');
        $this->setCustomerEmail($faker->email);
        $this->setCustomerPhone($faker->phoneNumber);
        $this->setCustomerIdNumber($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCustomerBankId(\Genesis\API\Constants\Banks::BOCO);
        $this->setBankAccountNumber($faker->numberBetween(1, PHP_INT_MAX));
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
