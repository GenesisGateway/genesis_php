<?php

namespace spec\Genesis\Api\Traits\Request\Financial\Business;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\Business\BusinessAttributesStub;
use spec\SharedExamples\Faker;

class TravelAgenciesAttributesSpec extends ObjectBehavior
{
    private static $validDates = [
        '2020-10-17',
        '17.10.2020',
        '20/10/2020',
        '22-11-2020'
    ];

    private static $invalidDate = '2021.01.19';

    public function let()
    {
        $this->beAnInstanceOf(BusinessAttributesStub::class);
    }

    public function it_should_set_business_arrival_date_in_valid_format()
    {
        foreach (self::$validDates as $date) {
            $this->shouldNotThrow()->during(
                'setBusinessArrivalDate',
                [$date]
            );
        }
    }

    public function it_should_fail_when_business_arrival_date_is_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBusinessArrivalDate',
            [self::$invalidDate]
        );
    }

    public function it_should_set_business_departure_date_in_valid_format()
    {
        foreach (self::$validDates as $date) {
            $this->shouldNotThrow()->during(
                'setBusinessDepartureDate',
                [$date]
            );
        }
    }

    public function it_should_fail_when_business_departure_date_is_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBusinessDepartureDate',
            [self::$invalidDate]
        );
    }

    public function it_should_set_business_pick_up_date_in_valid_format()
    {
        foreach (self::$validDates as $date) {
            $this->shouldNotThrow()->during(
                'setBusinessPickUpDate',
                [$date]
            );
        }
    }

    public function it_should_fail_when_business_pick_up_date_is_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBusinessPickUpDate',
            [self::$invalidDate]
        );
    }

    public function it_should_set_business_return_date_in_valid_format()
    {
        foreach (self::$validDates as $date) {
            $this->shouldNotThrow()->during(
                'setBusinessReturnDate',
                [$date]
            );
        }
    }

    public function it_should_fail_when_business_return_date_is_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBusinessReturnDate',
            [self::$invalidDate]
        );
    }

    public function it_should_be_business_arrival_date()
    {
        $format = Faker::getInstance()->randomElement(DateTimeFormat::getDateFormats());
        $date   = Faker::getInstance()->date($format);
        $this->setBusinessArrivalDate($date);

        $this->getBusinessArrivalDate()->shouldBeString();
        $this->getBusinessArrivalDate()->shouldBe(
            \DateTime::createFromFormat($format, $date)->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS)
        );
    }

    public function it_should_be_business_departure_date()
    {
        $format = Faker::getInstance()->randomElement(DateTimeFormat::getDateFormats());
        $date   = Faker::getInstance()->date($format);
        $this->setBusinessDepartureDate($date);

        $this->getBusinessDepartureDate()->shouldBeString();
        $this->getBusinessDepartureDate()->shouldBe(
            \DateTime::createFromFormat($format, $date)->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS)
        );
    }

    public function it_should_be_business_pick_up_date()
    {
        $format = Faker::getInstance()->randomElement(DateTimeFormat::getDateFormats());
        $date   = Faker::getInstance()->date($format);
        $this->setBusinessPickUpDate($date);

        $this->getBusinessPickUpDate()->shouldBeString();
        $this->getBusinessPickUpDate()->shouldBe(
            \DateTime::createFromFormat($format, $date)->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS)
        );
    }

    public function it_should_be_business_return_date()
    {
        $format = Faker::getInstance()->randomElement(DateTimeFormat::getDateFormats());
        $date   = Faker::getInstance()->date($format);
        $this->setBusinessReturnDate($date);

        $this->getBusinessReturnDate()->shouldBeString();
        $this->getBusinessReturnDate()->shouldBe(
            \DateTime::createFromFormat($format, $date)->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS)
        );
    }
}
