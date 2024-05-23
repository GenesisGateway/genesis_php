<?php

namespace spec\Genesis\Api\Request\Financial\Crypto\BitPay;

use Genesis\Api\Request\Financial\Crypto\BitPay\Refund;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class RefundSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Refund::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'currency',
            'reference_id'
        ]);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setReferenceId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency('EUR');
    }
}
