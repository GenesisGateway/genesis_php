<?php

namespace spec\Genesis\API\Traits\Request;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\DocumentAttributesStub;

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
