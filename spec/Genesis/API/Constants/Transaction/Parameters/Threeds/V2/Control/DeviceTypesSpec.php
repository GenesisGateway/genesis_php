<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Control;

use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Control\DeviceTypes;
use PhpSpec\ObjectBehavior;

class DeviceTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(DeviceTypes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
