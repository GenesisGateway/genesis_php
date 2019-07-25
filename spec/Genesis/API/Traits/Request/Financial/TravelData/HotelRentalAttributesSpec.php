<?php

namespace spec\Genesis\API\Traits\Request\Financial\TravelData;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\TravelData\TravelDataAttributesStub;

class HotelRentalAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(TravelDataAttributesStub::class);
    }

    public function it_should_set_hr_extra_charges_correctly()
    {
        $allowed = [ 2, 3, 4, 5, 6, 7 ];

        foreach ($allowed AS $value) {
            $this->shouldNotThrow()->during(
                'setHotelRentalExtraCharges',
                [$value]
            );
        }
    }

    public function it_should_set_hr_no_show_indicator_correctly()
    {
        $allowed = [ 0, 1 ];

        foreach ($allowed AS $value) {
            $this->shouldNotThrow()->during(
                'setHotelRentalNoShowIndicator',
                [$value]
            );
        }
    }

    public function it_should_fail_when_hr_no_show_indicator_is_invalid()
    {
        $this->shouldThrow()->during(
            'setHotelRentalNoShowIndicator',
            [5]
        );
    }

    public function it_should_fail_when_hr_extra_charges_is_invalid()
    {
        $this->shouldThrow()->during(
            'setHotelRentalExtraCharges',
            [88]
        );
    }
}
