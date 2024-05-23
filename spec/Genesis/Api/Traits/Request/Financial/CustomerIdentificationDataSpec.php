<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\CustomerIdentificationDataStub;

class CustomerIdentificationDataSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(CustomerIdentificationDataStub::class);
    }

    public function it_has_correct_customer_identification_structure()
    {
        $this->publicGetCustomerIdentificationDataStructure()->shouldBeArray();
    }

}