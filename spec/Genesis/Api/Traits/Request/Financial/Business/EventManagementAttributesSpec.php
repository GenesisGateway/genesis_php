<?php

namespace spec\Genesis\Api\Traits\Request\Financial\Business;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\Business\BusinessAttributesStub;
use spec\SharedExamples\Faker;

class EventManagementAttributesSpec extends ObjectBehavior
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

    public function it_should_set_business_event_start_date_in_valid_format()
    {
        foreach (self::$validDates as $date) {
            $this->shouldNotThrow()->during(
                'setBusinessEventStartDate',
                [$date]
            );
        }
    }

    public function it_should_fail_when_business_event_start_date_is_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBusinessEventStartDate',
            [self::$invalidDate]
        );
    }

    public function it_should_set_business_event_end_date_in_valid_format()
    {
        foreach (self::$validDates as $date) {
            $this->shouldNotThrow()->during(
                'setBusinessEventEndDate',
                [$date]
            );
        }
    }

    public function it_should_fail_when_business_event_end_date_is_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBusinessEventEndDate',
            [self::$invalidDate]
        );
    }

    public function it_should_be_business_event_start_date()
    {
        $format = Faker::getInstance()->randomElement(DateTimeFormat::getDateFormats());
        $date   = Faker::getInstance()->date($format);
        $this->setBusinessEventStartDate($date);

        $this->getBusinessEventStartDate()->shouldBeString();
        $this->getBusinessEventStartDate()->shouldBe(
	        \DateTime::createFromFormat($format, $date)->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS)
        );
    }

    public function it_should_be_business_event_end_date()
    {
        $format = Faker::getInstance()->randomElement(DateTimeFormat::getDateFormats());
        $date   = Faker::getInstance()->date($format);
        $this->setBusinessEventEndDate($date);

        $this->getBusinessEventEndDate()->shouldBeString();
        $this->getBusinessEventEndDate()->shouldBe(
            \DateTime::createFromFormat($format, $date)->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS)
        );
    }
}
