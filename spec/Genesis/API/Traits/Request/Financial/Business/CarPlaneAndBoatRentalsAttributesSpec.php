<?php

namespace spec\Genesis\API\Traits\Request\Financial\Business;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Business\BusinessAttributesStub;

class CarPlaneAndBoatRentalsAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BusinessAttributesStub::class);
    }

    public function it_should_set_business_vehicle_pick_up_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessVehiclePickUpDate',
            ['12-11-2020', '06-01-2020','1-1-2020']
        );
    }

    public function it_should_fail_when_business_vehicle_pick_up_date_is_invalid_format()
    {
        $this->shouldThrow()->during(
            'setBusinessVehiclePickUpDate',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_set_business_vehicle_return_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessVehicleReturnDate',
            ['12-11-2020', '04-05-2020', '1-1-2020']
        );
    }

    public function it_should_fail_when_business_vehicle_return_date_is_invalid()
    {
        $this->shouldThrow()->during(
            'setBusinessVehicleReturnDate',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_be_business_vehicle_pick_up_date()
    {
        $this->setBusinessVehiclePickUpDate('12-12-2021');
        $this->getBusinessVehiclePickUpDate()->shouldBeString();
    }

    public function it_should_be_business_vehicle_return_date()
    {
        $this->setBusinessVehicleReturnDate('12-12-2021');
        $this->getBusinessVehicleReturnDate()->shouldBeString();
    }
}
