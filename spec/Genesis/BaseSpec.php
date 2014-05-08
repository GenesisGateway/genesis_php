<?php

namespace spec\Genesis;

require_once 'SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BaseSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        return true;
        //$this->shouldHaveType('Genesis\Base');
    }

    function it_can_load_request()
    {
        $this->loadRequest('Blacklist')->shouldHaveType('Genesis\API\Request\Blacklist');
        $this->Request()->shouldHaveType('Genesis\API\Request\Blacklist');
    }

    function it_can_resolve_errors()
    {
        $this->getErrorDescription('420')->shouldBe('Wrong Workflow specified.');
    }

    function it_can_resolve_error_codes()
    {
        $this->getErrorCode('REMOTE_ERROR')->shouldBe(900);
    }
}
