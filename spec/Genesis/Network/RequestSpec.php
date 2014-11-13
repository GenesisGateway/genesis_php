<?php

namespace spec\Genesis\Network;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Genesis\API\Request as Request;

class RequestSpec extends ObjectBehavior
{
    function let(Request\FraudRelated\Blacklist $apiCtx)
    {
        $this->beConstructedWith($apiCtx, $apiCtx);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Network\Request');
    }
}
