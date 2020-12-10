<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Control;

use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Control\ChallengeIndicators;
use PhpSpec\ObjectBehavior;

class ChallengeIndicatorsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ChallengeIndicators::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
