<?php

namespace spec\Genesis\API\Traits\Request\Financial\Business;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Business\BusinessAttributesStub;
use spec\SharedExamples\Faker;

class CruiseLinesAttributesSpec extends ObjectBehavior
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

    public function it_should_set_business_cruise_start_date_in_valid_format()
    {
        foreach (self::$validDates as $date) {
            $this->shouldNotThrow()->during(
                'setBusinessCruiseStartDate',
                [$date]
            );
        }
    }

    public function it_should_fail_when_business_cruise_start_date_is_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBusinessCruiseStartDate',
            [self::$invalidDate]
        );
    }

    public function it_should_set_business_cruise_end_date_in_valid_format()
    {
        foreach (self::$validDates as $date) {
            $this->shouldNotThrow()->during(
                'setBusinessCruiseEndDate',
                [$date]
            );
        }
    }

    public function it_should_fail_when_business_cruise_end_date_is_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBusinessCruiseEndDate',
            [self::$invalidDate]
        );
    }

    public function it_should_be_business_cruise_start_date()
    {
        $format = Faker::getInstance()->randomElement(DateTimeFormat::getDateFormats());
        $date   = Faker::getInstance()->date($format);
        $this->setBusinessCruiseStartDate($date);

        $this->getBusinessCruiseStartDate()->shouldBeString();
        $this->getBusinessCruiseStartDate()->shouldBe(
            \DateTime::createFromFormat($format, $date)->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS)
        );
    }

    public function it_should_be_business_cruise_end_date()
    {
        $format = Faker::getInstance()->randomElement(DateTimeFormat::getDateFormats());
        $date   = Faker::getInstance()->date($format);
        $this->setBusinessCruiseEndDate($date);

        $this->getBusinessCruiseEndDate()->shouldBeString();
        $this->getBusinessCruiseEndDate()->shouldBe(
            \DateTime::createFromFormat($format, $date)->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS)
        );
    }
}
