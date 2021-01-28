<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters\OnlineBanking;

use Genesis\API\Constants\Transaction\Parameters\OnlineBanking\PaymentTypes;
use PhpSpec\ObjectBehavior;

class PaymentTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PaymentTypes::class);
    }

    public function it_should_be_array()
    {
        $this::getAll()->shouldBeArray();
    }
}
