<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use PhpSpec\ObjectBehavior;

class BeneficiaryAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf('spec\Genesis\Api\Stubs\Traits\Request\Financial\BeneficiaryAttributesStub');
    }

    public function it_should_be_array()
    {
        $this->returnBeneficiaryAttribStructure()->shouldBeArray();
    }

    public function it_should_have_indexes()
    {
        $this->returnBeneficiaryAttribStructure()->shouldHaveKey('beneficiary_bank_code');
        $this->returnBeneficiaryAttribStructure()->shouldHaveKey('beneficiary_name');
        $this->returnBeneficiaryAttribStructure()->shouldHaveKey('beneficiary_account_number');
    }
}
