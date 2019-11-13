<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters;

use Genesis\API\Constants\Transaction\Parameters\ScaExemptions;
use PhpSpec\ObjectBehavior;

class ScaExemptionsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ScaExemptions::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
