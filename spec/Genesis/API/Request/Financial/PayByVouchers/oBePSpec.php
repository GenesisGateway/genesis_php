<?php

namespace spec\Genesis\API\Request\Financial\PayByVouchers;

use Genesis\API\Request\Financial\PayByVouchers\oBeP;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

// @codingStandardsIgnoreStart
class oBePSpec extends ObjectBehavior
// @codingStandardsIgnoreEnd
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(oBeP::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'customer_name'
        ]);
    }

    public function it_should_fail_with_invalid_amount()
    {
        $this->setRequestParameters();

        $this->shouldThrow(InvalidArgument::class)->during('setAmount', ['-23.45']);
        $this->shouldThrow(InvalidArgument::class)->during('setAmount', ['23,45']);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setRemoteIp($faker->ipv4);
        $this->setCurrency('USD');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));

        $this->setCardType('virtual');
        $this->setRedeemType('instant');

        $this->setProductName('Paul Blart Mall Cop');
        $this->setProductCategory('movie');
        $this->setCustomerName('李');
        $this->setCustomerEmail($faker->email);
        $this->setCustomerPhone($faker->phoneNumber);
        $this->setCustomerIdNumber($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCustomerBankId(\Genesis\API\Constants\Banks::BOCO);
        $this->setBankAccountNumber($faker->numberBetween(1, PHP_INT_MAX));
    }
}
