<?php

namespace spec\Genesis\Exceptions;

use PhpSpec\ObjectBehavior;

class InvalidMethodSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Exceptions\InvalidMethod');
    }
}
