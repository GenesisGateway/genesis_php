<?php

namespace spec\Genesis\Api\Request\NonFinancial\Kyc\ClientVerification;

use Genesis\Api\Request\NonFinancial\Kyc\ClientVerification\Register;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;

class RegisterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Register::class);
    }

    public function it_can_build_structure()
    {
        $this->setReferenceId('reference_id');
        $this->getDocument()->shouldBeString();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setReferenceId(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_have_correct_endpoint()
    {
        $this->getApiConfig('url')
            ->shouldContain('https://staging.kyc.emerchantpay.net:443/api/v1/verifications/register');
    }
}
