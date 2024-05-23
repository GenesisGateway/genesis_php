<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\CashPayments;

use Genesis\Api\Constants\Transaction\Parameters\CashPayments\MaritalStatuses;
use PhpSpec\ObjectBehavior;

class MaritalStatusesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(MaritalStatuses::class);
    }

    public function it_should_be_array()
    {
        $this::getAll()->shouldBeArray();
    }
}
