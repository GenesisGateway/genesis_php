<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters;

use Genesis\Api\Constants\Transaction\Parameters\IFrameTargets;
use PhpSpec\ObjectBehavior;

class IFrameTargetsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(IFrameTargets::class);
    }

    public function it_should_be_array()
    {
        $this::getAll()->shouldBeArray();
    }
}
