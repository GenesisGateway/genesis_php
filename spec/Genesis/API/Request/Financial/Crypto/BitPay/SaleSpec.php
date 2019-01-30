<?php

namespace spec\Genesis\API\Request\Financial\Crypto\BitPay;

use Genesis\API\Request\Financial\Crypto\BitPay\Sale;
use PhpSpec\ObjectBehavior;

class SaleSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Sale::class);
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

    public function it_should_fail_when_missing_return_url_parameter()
    {
        $this->setRequestParameters();
        $this->setReturnUrl(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_amount_param()
    {
        $this->setRequestParameters();
        $this->setAmount(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_email_not_valid_param()
    {
        $this->shouldThrow()->during('setCustomerEmail', [ 'fdsfsfsf' ]);
    }

    public function it_should_set_correct_email()
    {
        $email = 'test@example.com';
        $this->shouldNotThrow()->during('setCustomerEmail', [ $email ]);
        $this->getCustomerEmail()->shouldBe($email);
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setReturnUrl($faker->url);
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency('EUR');
        $this->setCustomerEmail($faker->email);
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
