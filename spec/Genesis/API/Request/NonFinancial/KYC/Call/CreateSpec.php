<?php

namespace spec\Genesis\API\Request\NonFinancial\KYC\Call;

use Genesis\API\Request\NonFinancial\KYC\Call\Create;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;

class CreateSpec extends ObjectBehavior
{
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

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $this->setCustomerUniqueId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setTransactionUniqueId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCustomerPhoneNumber('359878664488');
        $this->setServiceLanguage('bg');
        $this->setSecurityCode(1234);
        $this->setServiceType(Create::CALL_SERVICE_TYPE_SMS);
    }

    public function getMatchers()
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            }
        );
    }
}
