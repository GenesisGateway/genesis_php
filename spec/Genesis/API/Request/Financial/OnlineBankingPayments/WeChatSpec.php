<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments;

use Genesis\API\Request\Financial\OnlineBankingPayments\WeChat;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\NeighborhoodAttributesExamples;

class WeChatSpec extends ObjectBehavior
{
    use RequestExamples, NeighborhoodAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(WeChat::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'usage',
            'amount',
            'currency',
            'billing_country',
            'return_success_url',
            'return_failure_url'
        ]);
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency('USD');
        $this->setBillingCountry('CA');
    }
}
