<?php

namespace spec\Genesis\API\Constants;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ErrorsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Constants\Errors');
    }

    function it_should_return_correct_code()
    {
        $this->getErrorDescription(100)->shouldBe('A general system error occurred.');
    }

    function it_should_return_correct_issuer_code()
    {
        $this->getIssuerResponseCode(04)->shouldBe('Do not honour');
        $this->getIssuerResponseCode(05)->shouldBe('Do not honour');
    }
}
