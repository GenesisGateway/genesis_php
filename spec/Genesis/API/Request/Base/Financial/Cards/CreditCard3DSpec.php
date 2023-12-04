<?php

namespace spec\Genesis\API\Request\Base\Financial\Cards;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Base\Request\Financial\Cards\CreditCard3DStub;

class CreditCard3DSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(CreditCard3DStub::class);
    }

    public function it_should_return_array_when_call_required_3ds_fields_conditional()
    {
        $this->getRequired3DSFieldsConditional()->shouldBeArray();
    }

    public function it_should_return_array_when_call_required_3ds_fields_groups()
    {
        $this->getRequired3DSFieldsGroups()->shouldBeArray();
    }
}
