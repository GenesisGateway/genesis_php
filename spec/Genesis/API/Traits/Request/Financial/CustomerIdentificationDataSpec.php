<?php

namespace spec\Genesis\API\Traits\Request\Financial;

use spec\Genesis\API\Stubs\Traits\Request\Financial\CustomerIdentificationDataStub;
use PhpSpec\ObjectBehavior;

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