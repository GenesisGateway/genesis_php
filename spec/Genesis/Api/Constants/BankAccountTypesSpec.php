<?php

namespace spec\Genesis\Api\Constants;

use Genesis\Api\Constants\BankAccountTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class BankAccountTypesSpec
 * @package spec\Genesis\Api\Constants
 */
class BankAccountTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(BankAccountTypes::class);
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
