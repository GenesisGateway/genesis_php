<?php

namespace spec\Genesis\API\Request\Financial\Crypto\BitPay;

use PhpSpec\ObjectBehavior;

class RefundSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\Crypto\BitPay\Refund');
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

    public function it_should_fail_when_missing_required_currency_param()
    {
        $this->setRequestParameters();
        $this->setCurrency(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_reference_id_param()
    {
        $this->setRequestParameters();
        $this->setReferenceId(null);
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setReferenceId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency('EUR');
    }

    public function getMatchers()
    {
        return [
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        ];
    }
}
