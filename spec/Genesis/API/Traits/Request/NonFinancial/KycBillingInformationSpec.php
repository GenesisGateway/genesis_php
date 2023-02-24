<?php

namespace spec\Genesis\API\Traits\Request\NonFinancial;

use Genesis\API\Constants\NonFinancial\KYC\Genders;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\NonFinancial\KycBillingInformationStub;
use spec\SharedExamples\Faker;

class KycBillingInformationSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(KycBillingInformationStub::class);
    }

    public function it_should_set_gender_correctly()
    {
        $allowed = Genders::getAll();

        foreach ($allowed AS $gender) {
            $this->shouldNotThrow()->during(
                'setKycBillingGender',
                [$gender]
            );
        }
    }

    public function it_should_fail_when_gender_is_invalid()
    {
        $this->shouldThrow()->during(
            'setKycBillingGender',
            ['FM']
        );
    }

    public function it_should_not_fail_with_proper_value_for_kyc_billing_birth_date()
    {
        $this->shouldNotThrow()->during('setKycBillingBirthDate',
            [Faker::getInstance()->date('Y-m-d')]
        );
    }

    public function it_should_fail_with_invalid_value_for_kyc_billing_birth_date()
    {
        $this->shouldThrow()->during('setKycBillingBirthDate',
            [Faker::getInstance()->date('Ymd')]
        );
    }

    public function it_should_return_string_for_kyc_billing_birth_date()
    {
        $this->setKycBillingBirthDate(Faker::getInstance()->date('Y-m-d'))
            ->getKycBillingBirthDate()->shouldBeString();
    }
}
