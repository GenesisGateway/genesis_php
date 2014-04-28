<?php

namespace spec\Genesis;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BaseSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Base');
    }

    function it_can_load_request()
    {
        $this->loadRequest('Blacklist')->shouldHaveType('Genesis\API\Request\Blacklist');
    }

    function it_can_format_correctly()
    {
        $this->uppercaseToUnderscore('setTokenData')->shouldBe('set_Token_Data');
    }
}
