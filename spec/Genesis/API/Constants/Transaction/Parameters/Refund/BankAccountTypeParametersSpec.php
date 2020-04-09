<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters\Refund;

use Genesis\API\Constants\Transaction\Parameters\Refund\BankAccountTypeParameters;
use PhpSpec\ObjectBehavior;

/**
 * Class BankAccountTypeParametersSpec
 * @package spec\Genesis\API\Constants\Transaction\Parameters\Refund
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
