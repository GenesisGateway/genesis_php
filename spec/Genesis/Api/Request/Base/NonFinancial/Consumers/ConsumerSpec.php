<?php

namespace spec\Genesis\Api\Request\Base\NonFinancial\Consumers;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Base\Request\NonFinancial\Consumers\BaseRequestStub;

class ConsumerSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BaseRequestStub::class);
    }

    public function it_should_set_version_correctly()
    {
        $this->shouldNotThrow()->during(
            'setVersion',
            ['v1']
        );
    }

    public function it_should_fail_if_version_is_invalid()
    {
        $this->shouldThrow()->during(
            'setVersion',
            ['v5']
        );
    }
}
