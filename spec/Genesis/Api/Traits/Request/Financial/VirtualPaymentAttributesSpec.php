<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\VirtualPaymentAttributesStub;

class VirtualPaymentAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(VirtualPaymentAttributesStub::class);
    }

    public function it_should_set_virtual_payment_address_correctly()
    {
        $this->shouldNotThrow()->during(
            'setVirtualPaymentAddress',
            ['someone@bank']
        );
    }

    public function it_should_throw_with_invalid_virtual_payment_address()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setVirtualPaymentAddress',
            ['bank']
        );
    }
}
