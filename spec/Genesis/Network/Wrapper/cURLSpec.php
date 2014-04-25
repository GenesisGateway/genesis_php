<?php

namespace spec\Genesis\Network\Wrapper;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class cURLSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Network\Wrapper\cURL');
    }
}
