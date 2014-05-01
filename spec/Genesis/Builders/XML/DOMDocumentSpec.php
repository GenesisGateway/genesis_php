<?php

namespace spec\Genesis\Builders\XML;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DOMDocumentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Builders\XML\DOMDocument');
    }
}
