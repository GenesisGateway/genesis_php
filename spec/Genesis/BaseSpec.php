<?php

namespace spec\Genesis;

require_once 'SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BaseSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('Blacklist');
        $this->shouldHaveType('Genesis\Base');
    }

    function it_can_load_request()
    {
        $this->beConstructedWith('Blacklist');
        $this->request()->shouldHaveType('Genesis\API\Request\Blacklist');
    }

    function it_can_resolve_errors()
    {
        $this->beConstructedWith('Blacklist');
        $this->getErrorDescription('420')->shouldBe('Wrong Workflow specified.');
    }

    function it_can_resolve_error_codes()
    {
        $this->beConstructedWith('Blacklist');
        $this->getErrorCode('REMOTE_ERROR')->shouldBe(900);
    }
}
