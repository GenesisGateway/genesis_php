<?php

namespace spec\Genesis\API\Request\NonFinancial\KYC\ConsumerRegistration;

use Genesis\API\Request\NonFinancial\KYC\ConsumerRegistration\Create;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
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

    public function it_should_fail_with_wrong_device_fingerprint_type()
    {
        $this->setRequestParameters();
        $this->shouldThrow(InvalidArgument::class)->during('setDeviceFingerprintType', [88]);
    }

    public function it_should_fail_with_wrong_profile_action_type()
    {
        $this->setRequestParameters();
        $this->shouldThrow(InvalidArgument::class)->during('setProfileActionType', [88]);
    }

    public function it_should_fail_with_wrong_profile_current_status()
    {
        $this->setRequestParameters();
        $this->shouldThrow(InvalidArgument::class)->during('setProfileCurrentStatus', [88]);
    }

    public function it_should_fail_with_wrong_industry_type()
    {
        $this->setRequestParameters();
        $this->shouldThrow(InvalidArgument::class)->during('setIndustryType', [88]);
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $this->setCustomerUniqueId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCustomerRegistrationDate(date('Y-m-d'));
        $this->setCustomerRegistrationIpAddress($faker->ipv4);
        $this->setCustomerEmail($faker->email);
        $this->setAddress1($faker->address);
        $this->setCity($faker->city);
        $this->setProvince($faker->city);
        $this->setZipCode($faker->postcode);
        $this->setCountry($faker->countryCode);
        $this->setFirstName($faker->firstName);
        $this->setLastName($faker->lastName);
    }

    public function getMatchers()
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        );
    }
}
