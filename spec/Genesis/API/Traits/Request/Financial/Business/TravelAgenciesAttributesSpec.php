<?php

namespace spec\Genesis\API\Traits\Request\Financial\Business;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Business\BusinessAttributesStub;

class TravelAgenciesAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BusinessAttributesStub::class);
    }

    public function it_should_set_business_arrival_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessArrivalDate',
            ['12-11-2020','01-01-2020']
        );
    }

    public function it_should_fail_when_business_arrival_date_is_invalid_format()
    {
        $this->shouldThrow()->during(
            'setBusinessArrivalDate',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_set_business_departure_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessDepartureDate',
            ['12-11-2020', '01-01-2020']
        );
    }

    public function it_should_fail_when_business_departure_date_is_invalid_format()
    {
        $this->shouldThrow()->during(
            'setBusinessDepartureDate',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_set_business_pick_up_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessPickUpDate',
            ['12-11-2020', '01-01-2020']
        );
    }

    public function it_should_fail_when_business_pick_up_date_is_invalid_format()
    {
        $this->shouldThrow()->during(
            'setBusinessPickUpDate',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_set_business_return_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessReturnDate',
            ['12-11-2020', '01-01-2020']
        );
    }

    public function it_should_fail_when_business_return_date_is_invalid_format()
    {
        $this->shouldThrow()->during(
            'setBusinessReturnDate',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_be_business_arrival_date()
    {
        $this->setBusinessArrivalDate('12-12-2021');
        $this->getBusinessArrivalDate()->shouldBeString();
    }

    public function it_should_be_business_departure_date()
    {
        $this->setBusinessDepartureDate('12-12-2021');
        $this->getBusinessDepartureDate()->shouldBeString();
    }

    public function it_should_be_business_pick_up_date()
    {
        $this->setBusinessPickUpDate('12-12-2021');
        $this->getBusinessPickUpDate()->shouldBeString();
    }

    public function it_should_be_business_return_date()
    {
        $this->setBusinessReturnDate('12-12-2021');
        $this->getBusinessReturnDate()->shouldBeString();
    }
}
