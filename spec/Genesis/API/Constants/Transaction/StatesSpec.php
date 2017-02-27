<?php

namespace spec\Genesis\API\Constants\Transaction;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StatesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Constants\Transaction\States');
    }
}
