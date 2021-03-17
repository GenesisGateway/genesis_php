<?php

namespace spec\Genesis\API\Traits\Request\Financial\Business;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Business\BusinessAttributesStub;
use spec\SharedExamples\Faker;

class HotelsAndRealEstateRentalsAttributesSpec extends ObjectBehavior
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

    public function it_should_set_business_check_in_date_in_valid_format()
    {
        foreach (self::$validDates as $date) {
            $this->shouldNotThrow()->during(
                'setBusinessCheckInDate',
                [$date]
            );
        }
    }

    public function it_should_fail_when_business_check_in_date_is_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBusinessCheckInDate',
            [self::$invalidDate]
        );
    }

    public function it_should_set_business_check_out_date_in_valid_format()
    {
        foreach (self::$validDates as $date) {
            $this->shouldNotThrow()->during(
                'setBusinessCheckOutDate',
                [$date]
            );
        }
    }

    public function it_should_fail_when_business_check_out_date_is_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBusinessCheckOutDate',
            [self::$invalidDate]
        );
    }

    public function it_should_be_business_check_in_date()
    {
        $format = Faker::getInstance()->randomElement(DateTimeFormat::getDateFormats());
        $date   = Faker::getInstance()->date($format);
        $this->setBusinessCheckInDate($date);

        $this->getBusinessCheckInDate()->shouldBeString();
        $this->getBusinessCheckInDate()->shouldbe(
            \DateTime::createFromFormat($format, $date)->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS)
        );
    }

    public function it_should_be_business_check_out_date()
    {
        $format = Faker::getInstance()->randomElement(DateTimeFormat::getDateFormats());
        $date   = Faker::getInstance()->date($format);
        $this->setBusinessCheckOutDate($date);

        $this->getBusinessCheckOutDate()->shouldBeString();
        $this->getBusinessCheckOutDate()->shouldBe(
            \DateTime::createFromFormat($format, $date)->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS)
        );
    }
}
