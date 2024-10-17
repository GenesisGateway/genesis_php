<?php

namespace spec\Genesis\Api\Request\Financial\Alternatives\Invoice;

use Genesis\Api\Request\Financial\Alternatives\Invoice\Refund;
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
            'amount',
            'currency',
            'reference_id'
        ]);
    }

    public function it_should_fail_when_missing_required_currency_param()
    {
        $this->setRequestParameters();
        $this->setCurrency(null);
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setReferenceId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setCurrency('EUR');
        $this->setAmount($faker->randomNumber(4));
    }
}
