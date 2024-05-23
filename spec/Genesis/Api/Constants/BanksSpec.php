<?php

namespace spec\Genesis\Api\Constants;

use PhpSpec\ObjectBehavior;

class BanksSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Api\Constants\Banks');
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
