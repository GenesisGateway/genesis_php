<?php

namespace spec\Genesis\API\Request\NonFinancial\KYC\ConsumerRegistration;

use Genesis\API\Request\NonFinancial\KYC\ConsumerRegistration\Create;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Traits\Request\Financial\BirthDateAttributesExample;

class CreateSpec extends ObjectBehavior
{
    use BirthDateAttributesExample;

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

    public function it_should_not_fail_when_set_correct_date_for_customer_registration_date()
    {
        $this->setRequestParameters();
        $dates = [
            Faker::getInstance()->date('Y-m-d'),
            Faker::getInstance()->date('d.m.Y')
        ];

        foreach ($dates as $date) {
            $this->shouldNotThrow()->during('setCustomerRegistrationDate', [$date]);
        }
    }

    public function it_should_fail_with_wrong_industry_type()
    {
        $this->setRequestParameters();
        $this->shouldThrow(InvalidArgument::class)->during('setIndustryType', [88]);
    }

    public function it_should_fail_when_invalid_date_for_customer_registration_date()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setCustomerRegistrationDate',
            [
                Faker::getInstance()->date('Ymd')
            ]
        );
    }

    public function it_should_return_string_when_get_customer_registration_date()
    {
        $this->setCustomerRegistrationDate(Faker::getInstance()->date('Y-m-d'))
            ->getCustomerRegistrationDate()->shouldBeString();
    }

    public function it_should_not_fail_when_set_correct_date_for_bonus_submission_date()
    {
        $this->setRequestParameters();
        $dates = [
            Faker::getInstance()->date('Y-m-d'),
            Faker::getInstance()->date('d.m.Y')
        ];

        foreach ($dates as $date) {
            $this->shouldNotThrow()->during('setBonusSubmissionDate', [$date]);
        }
    }

    public function it_should_fail_when_invalid_date_for_bonus_submission_date()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setBonusSubmissionDate',
            [
                Faker::getInstance()->date('Ymd')
            ]
        );
    }

    public function it_should_return_string_when_get_bonus_submission_date()
    {
        $this->setBonusSubmissionDate(Faker::getInstance()->date('Y-m-d'))
            ->getBonusSubmissionDate()->shouldBeString();
    }

    public function it_should_have_correct_consumer_registration_endpoint()
    {
        $this->getApiConfig('url')->shouldContain(
            'https://staging.kyc.emerchantpay.net:443/api/v1/create_consumer'
        );
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $this->setCustomerUniqueId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCustomerRegistrationDate($faker->date('Y-m-d'));
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

    public function getMatchers(): array
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        );
    }
}
