<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters;

use Genesis\API\Constants\Transaction\Parameters\IdentificationTypes;
use PhpSpec\ObjectBehavior;

class IdentificationTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(IdentificationTypes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
