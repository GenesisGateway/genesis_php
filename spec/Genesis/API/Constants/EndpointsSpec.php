<?php

namespace spec\Genesis\API\Constants;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EndpointsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Constants\Endpoints');
    }
}
