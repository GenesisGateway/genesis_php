<?php

namespace spec\Genesis\Api\Traits\Request;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\DocumentAttributesStub;

class DocumentAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(DocumentAttributesStub::class);
    }

    public function it_should_have_proper_structure()
    {
        $this->getDocumentIdConditions()->shouldBeArray();
    }
}
