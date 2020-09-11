<?php

namespace spec\Genesis\API\Traits\Request\Financial\Business;

use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Business\BusinessAttributesStub;

class AirlinesAirCarriersAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BusinessAttributesStub::class);
    }

    public function it_should_set_business_flight_arrival_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessFlightArrivalDate',
            ['12-11-2020', '09-08-2020']
        );
    }

    public function it_should_fail_when_business_flight_arrival_date_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBusinessFlightArrivalDate',
            ['2020-10-12', '10.10.2020','10/10/2020']
        );
    }

    public function it_should_set_business_flight_departure_date_in_valid_format()
    {
        $this->shouldNotThrow()->during(
            'setBusinessFlightDepartureDate',
            ['12-11-2020', '02-02-2020']
        );
    }

    public function it_should_fail_when_business_flight_departure_date_is_invalid_format()
    {
        $this->shouldThrow()->during(
            'setBusinessFlightDepartureDate',
            ['2020-01-10']
        );
    }

    public function it_should_be_string_flight_arrival_date()
    {
        $this->setBusinessFlightArrivalDate('12-11-2020');
        $this->getBusinessFlightArrivalDate()->shouldBeString();
    }

    public function it_should_be_flight_departure_date()
    {
        $this->setBusinessFlightDepartureDate('12-12-2021');
        $this->getBusinessFlightDepartureDate()->shouldBeString();
    }
}
