<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\CashPayments;

use Genesis\Api\Constants\Transaction\Parameters\CashPayments\CompanyTypes;
use PhpSpec\ObjectBehavior;

class CompanyTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CompanyTypes::class);
    }

    public function it_should_be_array()
    {
        $this::getAll()->shouldBeArray();
    }
}
