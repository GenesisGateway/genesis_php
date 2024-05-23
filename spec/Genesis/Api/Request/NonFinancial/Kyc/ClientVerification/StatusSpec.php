<?php

namespace spec\Genesis\Api\Request\NonFinancial\Kyc\ClientVerification;

use Genesis\Api\Request\NonFinancial\Kyc\ClientVerification\Status;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class StatusSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Status::class);
    }

    public function it_should_have_correct_consumer_verification_endpoint()
    {
        $this->getApiConfig('url')
             ->shouldContain('https://staging.kyc.emerchantpay.net:443/api/v1/verifications/status');
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->testMissingRequiredParameters([
            'reference_id'
        ]);
    }

    protected function setRequestParameters()
    {
        $this->setReferenceId($this->getFaker()->uuid());
    }
}
