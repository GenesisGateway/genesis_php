<?php

namespace spec\Genesis\Api\Traits\Request\Financial\TravelData;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\TravelData\TravelDataAttributesStub;
use spec\SharedExamples\Faker;

class CarRentalAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(TravelDataAttributesStub::class);
    }

    public function it_should_set_cr_class_id_correctly()
    {
        $allowed = [
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18,
            19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 9999
        ];

        foreach ($allowed AS $value) {
            $this->shouldNotThrow()->during(
                'setCarRentalClassId',
                [$value]
            );
        }
    }

    public function it_should_set_cr_extra_charges_correctly()
    {
        $allowed = [ 1, 2, 3, 4, 5 ];

        foreach ($allowed AS $value) {
            $this->shouldNotThrow()->during(
                'setCarRentalExtraCharges',
                [$value]
            );
        }
    }

    public function it_should_set_cr_no_show_indicator_correctly()
    {
        $allowed = [ 0, 1 ];

        foreach ($allowed AS $value) {
            $this->shouldNotThrow()->during(
                'setCarRentalNoShowIndicator',
                [$value]
            );
        }
    }

    public function it_should_fail_when_cr_no_show_indicator_is_invalid()
    {
        $this->shouldThrow()->during(
            'setCarRentalNoShowIndicator',
            [5]
        );
    }

    public function it_should_fail_when_cr_extra_charges_is_invalid()
    {
        $this->shouldThrow()->during(
            'setCarRentalExtraCharges',
            [88]
        );
    }

    public function it_should_fail_when_cr_class_id_is_invalid()
    {
        $this->shouldThrow()->during(
            'setCarRentalClassId',
            [7777]
        );
    }

    public function it_should_not_fail_when_set_correct_date_car_rental_pickup_date()
    {
        $this->shouldNotThrow()->during('setCarRentalPickupDate',
            [Faker::getInstance()->date('Y-m-d')]
        );
        $this->shouldNotThrow()->during('setCarRentalPickupDate',
            [Faker::getInstance()->date('d.m.Y')]
        );
    }

    public function it_should_not_fail_when_set_correct_date_car_rental_return_date()
    {
        $this->shouldNotThrow()->during('setCarRentalReturnDate',
            [Faker::getInstance()->date('Y-m-d')]
        );
        $this->shouldNotThrow()->during('setCarRentalReturnDate',
            [Faker::getInstance()->date('d.m.Y')]
        );
    }

    public function it_should_fail_when_set_invalid_date_car_rental_pickup_date()
    {
        $this->shouldThrow()->during('setCarRentalPickupDate',
            [Faker::getInstance()->date('Ymd')]
        );
    }

    public function it_should_fail_when_set_invalid_date_car_rental_return_date()
    {
        $this->shouldThrow()->during('setCarRentalReturnDate',
            [Faker::getInstance()->date('Ymd')]
        );
    }

    public function it_should_return_string_car_rental_pickup_date()
    {
        $this->setCarRentalPickupDate(Faker::getInstance()->date('Y-m-d'))
            ->getCarRentalPickupDate()->shouldBeString();
    }

    public function it_should_return_string_car_rental_return_date()
    {
        $this->setCarRentalReturnDate(Faker::getInstance()->date('Y-m-d'))
            ->getCarRentalReturnDate()->shouldBeString();
    }
}
