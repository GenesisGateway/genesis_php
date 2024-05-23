<?php

namespace spec\Genesis\Api\Request\NonFinancial\Kyc\Call;

use Genesis\Api\Constants\NonFinancial\Kyc\CallServiceTypes;
use Genesis\Api\Request\NonFinancial\Kyc\Call\Create;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\Kyc\KycRequestExamples;

class CreateSpec extends ObjectBehavior
{
    use KycRequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Create::class);
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
        $this->setCustomerUniqueId(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_with_wrong_service_type()
    {
        $this->setRequestParameters();
        $this->setServiceType(88);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_with_wrong_security_code()
    {
        $this->setRequestParameters();
        $this->setSecurityCode(88);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_with_wrong_service_language()
    {
        $this->setRequestParameters();
        $this->setServiceLanguage('BG');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_have_correct_call_create_endpoint()
    {
        $this->getApiConfig('url')->shouldContain(
            'https://staging.kyc.emerchantpay.net:443/api/v1/create_authentication'
        );
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $this->setCustomerUniqueId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setTransactionUniqueId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCustomerPhoneNumber('359878664488');
        $this->setServiceLanguage('bg');
        $this->setSecurityCode(1234);
        $this->setServiceType(CallServiceTypes::SMS);
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
