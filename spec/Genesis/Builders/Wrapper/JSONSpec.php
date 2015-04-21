<?php

namespace spec\Genesis\Builders\Wrapper;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JSONSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Builders\Wrapper\JSON');
    }
}
