<?php

namespace spec\Genesis\Builders;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XMLSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Builders\XML');
    }
}
