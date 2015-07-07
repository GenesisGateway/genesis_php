<?php

namespace spec\Genesis;

require_once 'SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GenesisSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('NonFinancial\Blacklist');
        $this->shouldHaveType('Genesis\Genesis');
    }

    function it_can_load_request()
    {
        $this->beConstructedWith('NonFinancial\Blacklist');
        $this->request()->shouldHaveType('\Genesis\API\Request\NonFinancial\Blacklist');
    }
}
