<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\PayeeAttributesStub;

class PayeeAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(PayeeAttributesStub::class);
    }

    public function it_should_set_payee_unique_id()
    {
        $this->shouldNotThrow()->during('setPayeeUniqueId', ['unique_id']);
    }
}
