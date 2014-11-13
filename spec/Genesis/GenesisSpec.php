<?php

namespace spec\Genesis;

require_once 'SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GenesisSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('FraudRelated\Blacklist');
        $this->shouldHaveType('Genesis\Genesis');
    }

    function it_can_load_request()
    {
        $this->beConstructedWith('FraudRelated\Blacklist');
        $this->request()->shouldHaveType('\Genesis\API\Request\FraudRelated\Blacklist');
    }

    function it_can_resolve_errors()
    {
        $this->beConstructedWith('FraudRelated\Blacklist');
        $this->getErrorDescription('420')->shouldBe('Wrong Workflow specified.');
    }

    function it_can_resolve_error_codes()
    {
        $this->beConstructedWith('FraudRelated\Blacklist');
        $this->getErrorCode('REMOTE_ERROR')->shouldBe(900);
    }
}
