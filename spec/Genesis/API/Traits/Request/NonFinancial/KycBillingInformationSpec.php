<?php

namespace spec\Genesis\API\Traits\Request\NonFinancial;

use Genesis\API\Request\Base\NonFinancial\KYC\BaseRequest;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\NonFinancial\KycBillingInformationStub;

class KycBillingInformationSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(KycBillingInformationStub::class);
    }

    public function it_should_set_gender_correctly()
    {
        $allowed = [
            BaseRequest::GENDER_MALE,
            BaseRequest::GENDER_FEMALE
        ];

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
}
