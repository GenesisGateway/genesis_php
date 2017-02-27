<?php

namespace spec\Genesis;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NetworkSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Network');
    }

    // TODO: Spec the interface
}
