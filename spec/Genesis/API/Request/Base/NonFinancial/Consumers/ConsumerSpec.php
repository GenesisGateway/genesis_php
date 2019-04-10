<?php

namespace spec\Genesis\API\Request\Base\NonFinancial\Consumers;

use PhpSpec\ObjectBehavior;

class ConsumerSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf('spec\Genesis\API\Stubs\Base\Request\NonFinancial\Consumers\BaseRequestStub');
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
