<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\PayeeAccountAttributesStub;

class PayeeAccountAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(PayeeAccountAttributesStub::class);
    }

    public function it_should_set_account_unique_id()
    {
        $this->shouldNotThrow()->during('setAccountUniqueId', ['unique_id']);
    }
}
