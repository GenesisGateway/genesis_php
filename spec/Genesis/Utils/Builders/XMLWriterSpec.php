<?php

namespace spec\Genesis\Utils\Builders;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XMLWriterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Utils\Builders\XMLWriter');
    }
}
