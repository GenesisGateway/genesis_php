<?php

namespace spec\Genesis\Api\Request\Financial;

use Genesis\Api\Request\Financial\Capture;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Traits\Request\Financial\InstallmentAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\Business\BusinessAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class CaptureSpec extends ObjectBehavior
{
    use BusinessAttributesExample;
    use RequestExamples;
    use InstallmentAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Capture::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'reference_id'
        ]);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency(
            $faker->randomElement(
                \Genesis\Utils\Currency::getList()
            )
        );
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setReferenceId($faker->numberBetween(1, PHP_INT_MAX));
    }
}
