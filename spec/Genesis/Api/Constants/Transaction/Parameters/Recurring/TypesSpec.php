<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\Recurring;

use Genesis\Api\Constants\Transaction\Parameters\Recurring\Types;
use PhpSpec\ObjectBehavior;

class TypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Types::class);
    }

    public function it_should_be_array_initial_types()
    {
        $this::getInitialTypes()->shouldBeArray();
    }

    public function it_should_be_array_subsequent_types()
    {
        $this::getSubsequentTypes()->shouldBeArray();
    }
}
