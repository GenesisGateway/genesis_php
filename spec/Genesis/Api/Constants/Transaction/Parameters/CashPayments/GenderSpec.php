<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\CashPayments;

use Genesis\Api\Constants\Transaction\Parameters\CashPayments\Gender;
use PhpSpec\ObjectBehavior;

class GenderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Gender::class);
    }

    public function it_should_be_array()
    {
        $this::getAll()->shouldBeArray();
    }
}
