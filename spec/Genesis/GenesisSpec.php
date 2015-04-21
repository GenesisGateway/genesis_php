<?php

namespace spec\Genesis;

require_once 'SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GenesisSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('NonFinancial\Fraud\Blacklist');
        $this->shouldHaveType('Genesis\Genesis');
    }

    function it_can_load_request()
    {
        $this->beConstructedWith('NonFinancial\Fraud\Blacklist');
        $this->request()->shouldHaveType('\Genesis\API\Request\NonFinancial\Fraud\Blacklist');
    }

    function it_can_resolve_errors()
    {
        $this->beConstructedWith('NonFinancial\Fraud\Blacklist');
        $this->getErrorDescription('420')->shouldBe('Wrong Workflow specified.');
    }

    function it_can_resolve_error_codes()
    {
        $this->beConstructedWith('NonFinancial\Fraud\Blacklist');
        $this->getErrorCode('REMOTE_ERROR')->shouldBe(900);
    }
}
