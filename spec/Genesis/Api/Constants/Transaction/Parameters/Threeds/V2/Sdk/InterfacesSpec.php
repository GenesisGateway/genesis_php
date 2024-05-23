<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Sdk;

use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Sdk\Interfaces;
use PhpSpec\ObjectBehavior;

class InterfacesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Interfaces::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
