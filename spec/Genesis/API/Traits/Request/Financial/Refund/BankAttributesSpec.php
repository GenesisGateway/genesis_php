<?php

namespace spec\Genesis\API\Traits\Request\Financial\Refund;

use Genesis\API\Constants\Transaction\Parameters\Refund\BankAccountTypeParameters;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Refund\BankAttributesStub;
use spec\SharedExamples\Faker;

/**
 * Class BankAttributesSpec
 * @package spec\Genesis\API\Traits\Request\Financial\Refund
 */
class BankAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BankAttributesStub::class);
    }

    public function it_should_not_fail_with_proper_bank_account_type_value()
    {
        $faker = Faker::getInstance();
        $this->shouldNotThrow()->during(
            'setBankAccountType',
            [$faker->randomElement(BankAccountTypeParameters::getAll())]
        );
    }

    public function it_should_fail_with_invalid_bank_account_type_value()
    {
        $faker = Faker::getInstance();
        $this->shouldThrow()->during(
            'setBankAccountType',
            [$faker->asciify('**')]
        );
    }

    public function it_should_get_bank_structure_return_array()
    {
        $this->getStructure()->shouldBeArray();
    }

    public function it_should_have_proper_structure()
    {
        $this->getStructure()->shouldHaveKey('bank');
        $this->getStructure()->shouldHaveKey('bank_branch');
        $this->getStructure()->shouldHaveKey('bank_account');
        $this->getStructure()->shouldHaveKey('bank_account_type');
    }
}
