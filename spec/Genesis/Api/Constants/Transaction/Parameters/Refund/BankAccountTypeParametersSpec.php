<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\Refund;

use Genesis\Api\Constants\Transaction\Parameters\Refund\BankAccountTypeParameters;
use PhpSpec\ObjectBehavior;

/**
 * Class BankAccountTypeParametersSpec
 * @package spec\Genesis\Api\Constants\Transaction\Parameters\Refund
 */
class BankAccountTypeParametersSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(BankAccountTypeParameters::class);
    }

    public function it_should_be_array_get_all()
    {
        $this->getAll()->shouldBeArray();
    }

    public function it_should_not_be_empty_array_get_all()
    {
        $this->getAll()->shouldNotBeEqualTo([]);
    }
}
