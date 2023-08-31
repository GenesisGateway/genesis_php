<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters\Funding;

use PhpSpec\ObjectBehavior;

class IdentifierTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Constants\Transaction\Parameters\Funding\IdentifierTypes');
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
