<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\Alternatives\P24;

use Genesis\Api\Constants\Transaction\Parameters\Alternatives\P24\BankCodes;
use PhpSpec\ObjectBehavior;

class BankCodesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(BankCodes::class);
    }

    public function it_should_be_array()
    {
        $this::getAll()->shouldBeArray();
    }
}
