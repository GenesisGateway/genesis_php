<?php

namespace spec\Genesis\API\Constants;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BanksSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Constants\Banks');
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
