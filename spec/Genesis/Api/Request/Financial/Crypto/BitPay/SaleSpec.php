<?php

namespace spec\Genesis\Api\Request\Financial\Crypto\BitPay;

use Genesis\Api\Request\Financial\Crypto\BitPay\Sale;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class SaleSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Sale::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'amount',
            'currency',
            'return_url'
        ]);
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
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setReturnUrl($faker->url);
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency('EUR');
        $this->setCustomerEmail($faker->email);
    }
}
