<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Browser;

use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Browser\ColorDepths;
use PhpSpec\ObjectBehavior;

class ColorDepthsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ColorDepths::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
