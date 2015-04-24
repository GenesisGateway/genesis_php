<?php

namespace spec\Genesis;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Genesis\API\Request as Request;

class NetworkSpec extends ObjectBehavior
{
    function let(Request\NonFinancial\Fraud\Blacklist $apiCtx)
    {
        $this->beConstructedWith($apiCtx, $apiCtx);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Network');
    }
}
