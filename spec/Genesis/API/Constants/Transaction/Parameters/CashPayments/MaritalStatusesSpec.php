<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters\CashPayments;

use Genesis\API\Constants\Transaction\Parameters\CashPayments\MaritalStatuses;
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
