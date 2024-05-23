<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Sdk;

use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Sdk\UiTypes;
use PhpSpec\ObjectBehavior;

class UiTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(UiTypes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
