<?php

namespace spec\Genesis\Api\Request\NonFinancial\Kyc\Call;

use Genesis\Api\Constants\NonFinancial\Kyc\CallVerificationStatuses;
use Genesis\Api\Request\NonFinancial\Kyc\Call\Update;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;

class UpdateSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Update::class);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setReferenceId(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_with_wrong_verification_status()
    {
        $this->setRequestParameters();
        $this->setVerificationStatus(88);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_with_wrong_security_code_input()
    {
        $this->setRequestParameters();
        $this->setSecurityCodeInput('0000');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_have_correct_call_update_endpoint()
    {
        $this->getApiConfig('url')->shouldContain(
            'https://staging.kyc.emerchantpay.net:443/api/v1/update_authentication'
        );
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $this->setReferenceId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setVerificationStatus(CallVerificationStatuses::VERIFICATION_SUCCESS);
        $this->setSecurityCodeInput(1234);
    }

    public function getMatchers(): array
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            }
        );
    }
}
