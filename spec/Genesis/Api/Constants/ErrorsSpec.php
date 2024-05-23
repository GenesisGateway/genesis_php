<?php

namespace spec\Genesis\Api\Constants;

use PhpSpec\ObjectBehavior;

class ErrorsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Api\Constants\Errors');
    }

    public function it_can_resolve_error_codes()
    {
        $this::getErrorCode('REMOTE_ERROR')->shouldBe(900);
    }

    public function it_can_resolve_errors()
    {
        $this::getErrorDescription('420')->shouldBe('Wrong Workflow specified.');
    }

    public function it_should_return_correct_code()
    {
        $this::getErrorDescription(100)->shouldBe('A general system error occurred.');
    }

    public function it_should_return_correct_issuer_code()
    {
        $this::getIssuerResponseCode(04)->shouldBe('Pick-up card');
        $this::getIssuerResponseCode(05)->shouldBe('Do not honour');
    }
}
