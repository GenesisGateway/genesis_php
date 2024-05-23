<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Control;

use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Control\ChallengeWindowSizes;
use PhpSpec\ObjectBehavior;

class ChallengeWindowSizesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ChallengeWindowSizes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
