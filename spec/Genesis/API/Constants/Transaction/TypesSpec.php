<?php

namespace spec\Genesis\API\Constants\Transaction;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TypesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Constants\Transcation\Types');
    }
}
