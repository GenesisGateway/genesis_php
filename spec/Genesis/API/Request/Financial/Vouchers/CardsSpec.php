<?php

namespace spec\Genesis\API\Request\Financial\Vouchers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CardsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\Vouchers\Cards');
    }
}
