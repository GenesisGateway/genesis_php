<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters;

use Genesis\API\Constants\Transaction\Parameters\SourceOfFunds;
use PhpSpec\ObjectBehavior;

class SourceOfFundsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SourceOfFunds::class);
    }

    public function it_should_be_array_source_of_funds_getAll()
    {
        $this->getAll()->shouldBeArray();
    }
}
