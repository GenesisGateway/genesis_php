<?php

namespace spec\Genesis\API\Traits\Request\Financial\Business;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Business\BusinessAttributesStub;

class FurnitureAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BusinessAttributesStub::class);
    }

    public function it_should_set_business_date_of_order_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessDateOfOrder',
            ['12-11-2020', '01-01-2020']
        );
    }

    public function it_should_fail_when_business_date_of_order_is_invalid_format()
    {
        $this->shouldThrow()->during(
            'setBusinessDateOfOrder',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_set_business_delivery_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessDeliveryDate',
            ['12-11-2020', '03-01-2020']
        );
    }

    public function it_should_fail_when_business_delivery_date_is_invalid_format()
    {
        $this->shouldThrow()->during(
            'setBusinessDeliveryDate',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_be_business_date_of_roder()
    {
        $this->setBusinessDateOfOrder('12-12-2021');
        $this->getBusinessDateOfOrder()->shouldBeString();
    }

    public function it_should_be_business_delivery_date()
    {
        $this->setBusinessDeliveryDate('12-12-2021');
        $this->getBusinessDeliveryDate()->shouldBeString();
    }
}
