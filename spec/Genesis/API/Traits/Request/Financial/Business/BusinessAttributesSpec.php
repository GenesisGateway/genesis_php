<?php

namespace spec\Genesis\API\Traits\Request\Financial\Business;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Business\BusinessAttributesStub;

class BusinessAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BusinessAttributesStub::class);
    }

    public function it_should_be_array()
    {
        $this->getBusinessAttributesStructure()->shouldBeArray();
    }

    public function it_should_have_indexes()
    {
        // AirlinesAirCarriersAttributes structure
        $this->getBusinessAttributesStructure()->shouldHaveKey('flight_arrival_date');
        $this->getBusinessAttributesStructure()->shouldHaveKey('flight_departure_date');
        $this->getBusinessAttributesStructure()->shouldHaveKey('airline_code');
        $this->getBusinessAttributesStructure()->shouldHaveKey('airline_flight_number');
        $this->getBusinessAttributesStructure()->shouldHaveKey('flight_ticket_number');
        $this->getBusinessAttributesStructure()->shouldHaveKey('flight_origin_city');
        $this->getBusinessAttributesStructure()->shouldHaveKey('flight_destination_city');
        $this->getBusinessAttributesStructure()->shouldHaveKey('airline_tour_operator_name');

        // EventManagementAttributes structure
        $this->getBusinessAttributesStructure()->shouldHaveKey('event_start_date');
        $this->getBusinessAttributesStructure()->shouldHaveKey('event_end_date');
        $this->getBusinessAttributesStructure()->shouldHaveKey('event_organizer_id');
        $this->getBusinessAttributesStructure()->shouldHaveKey('event_id');

        // FurnitureAttributes structure
        $this->getBusinessAttributesStructure()->shouldHaveKey('date_of_order');
        $this->getBusinessAttributesStructure()->shouldHaveKey('delivery_date');
        $this->getBusinessAttributesStructure()->shouldHaveKey('name_of_the_supplier');

        // HotelsAndRealEstateRentalsAttributes structure
        $this->getBusinessAttributesStructure()->shouldHaveKey('check_in_date');
        $this->getBusinessAttributesStructure()->shouldHaveKey('check_out_date');
        $this->getBusinessAttributesStructure()->shouldHaveKey('travel_agency_name');

        // CarPlaneAndBoatRentalsAttributes structure
        $this->getBusinessAttributesStructure()->shouldHaveKey('vehicle_pick_up_date');
        $this->getBusinessAttributesStructure()->shouldHaveKey('vehicle_return_date');
        $this->getBusinessAttributesStructure()->shouldHaveKey('supplier_name');

        // CruiseLinesAttributes structure
        $this->getBusinessAttributesStructure()->shouldHaveKey('cruise_start_date');
        $this->getBusinessAttributesStructure()->shouldHaveKey('cruise_end_date');

        // TravelAgenciesAttributes structure
        $this->getBusinessAttributesStructure()->shouldHaveKey('arrival_date');
        $this->getBusinessAttributesStructure()->shouldHaveKey('departure_date');
        $this->getBusinessAttributesStructure()->shouldHaveKey('carrier_code');
        $this->getBusinessAttributesStructure()->shouldHaveKey('flight_number');
        $this->getBusinessAttributesStructure()->shouldHaveKey('ticket_number');
        $this->getBusinessAttributesStructure()->shouldHaveKey('origin_city');
        $this->getBusinessAttributesStructure()->shouldHaveKey('destination_city');
        $this->getBusinessAttributesStructure()->shouldHaveKey('travel_agency');
        $this->getBusinessAttributesStructure()->shouldHaveKey('contractor_name');
        $this->getBusinessAttributesStructure()->shouldHaveKey('atol_certificate');
        $this->getBusinessAttributesStructure()->shouldHaveKey('pick_up_date');
        $this->getBusinessAttributesStructure()->shouldHaveKey('return_date');
    }
}
