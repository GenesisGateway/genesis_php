<?php

namespace spec\Genesis\Api\Request\Base\NonFinancial\TokenizationApi;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Base\Request\NonFinancial\TokenizationApi\BaseRequestStub;

class TokenizationApiSpec extends ObjectBehavior
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

    public function it_should_fail_with_nonexistent_version()
    {
        $this->shouldThrow()->during(
            'setVersion',
            ['v2']
        );
    }

    public function it_should_set_proper_tree_structure()
    {
        $this->getTreeStructure()->shouldHaveKey('test_request');
    }
}
