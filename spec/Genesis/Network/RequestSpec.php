<?php

namespace spec\Genesis\Network;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Genesis\Configuration;

class RequestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Network\Request');
    }
}
