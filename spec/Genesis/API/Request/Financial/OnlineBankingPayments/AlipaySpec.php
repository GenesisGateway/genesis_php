<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments;

use Genesis\API\Request\Financial\OnlineBankingPayments\Alipay;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Traits\Request\Financial\BirthDateAttributesExample;

class AlipaySpec extends ObjectBehavior
{
    use RequestExamples, BirthDateAttributesExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Alipay::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'usage',
            'remote_ip',
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url'
        ]);
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency('CNY');
        $this->setBillingCountry('CA');
    }
}
