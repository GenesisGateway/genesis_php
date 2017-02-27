<?php

namespace spec\Genesis\API\Constants\Payment;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MethodsSpec extends ObjectBehavior
{
    protected function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Constants\Payment\Methods');
    }
}
