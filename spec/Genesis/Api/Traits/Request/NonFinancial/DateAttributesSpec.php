<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\Exception;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\DateAttributesStub;
use spec\SharedExamples\Faker;

class DateAttributesSpec extends ObjectBehavior
{
    private $faker;

    public function let()
    {
        $this->beAnInstanceOf(DateAttributesStub::class);
    }

    public function __construct()
    {
        $this->faker = Faker::getInstance();
    }

    public function it_should_not_throw_when_start_date_with_setter_without_timestamp()
    {
        $this->shouldNotThrow()->duringSetStartDate($this->faker->date(DateTimeFormat::YYYY_MM_DD_ISO_8601));
    }

    public function it_should_not_throw_when_start_date_with_setter_with_timestamp()
    {
        $this->shouldNotThrow()->duringSetStartDate($this->faker->date(DateTimeFormat::YYYY_MM_DD_H_I_S));
    }

    public function it_should_not_throw_when_start_date_with_setter_with_null_value()
    {
        $this->shouldNotThrow()->duringSetStartDate(null);
    }

    public function it_when_start_date_with_getter_with_string_value()
    {
        $this->setStartDate($this->faker->date(DateTimeFormat::YYYY_MM_DD_H_I_S));

        $this->getStartDate()->shouldBeString();
    }

    public function it_should_not_throw_when_end_date_with_setter_without_timestamp()
    {
        $this->shouldNotThrow()->duringSetEndDate($this->faker->date(DateTimeFormat::YYYY_MM_DD_ISO_8601));
    }

    public function it_should_not_throw_when_end_date_with_setter_with_timestamp()
    {
        $this->shouldNotThrow()->duringSetEndDate($this->faker->date(DateTimeFormat::YYYY_MM_DD_H_I_S));
    }

    public function it_should_not_throw_when_end_date_with_setter_with_null_value()
    {
        $this->shouldNotThrow()->duringSetEndDate(null);
    }

    public function it_when_end_date_with_getter_with_string_value()
    {
        $this->setEndDate($this->faker->date(DateTimeFormat::YYYY_MM_DD_H_I_S));

        $this->getEndDate()->shouldBeString();
    }

    public function it_should_not_throw_when_group_dates_with_valid_requirements()
    {
        $this->setStartDate($this->faker->date(DateTimeFormat::YYYY_MM_DD_H_I_S));
        $this->setEndDate($this->faker->date(DateTimeFormat::YYYY_MM_DD_H_I_S));

        $this->shouldNotThrow()->duringPublicValidateGroupRequirements();
    }

    public function it_should_throw_when_group_dates_with_invalid_requirements()
    {
        $this->setStartDate($this->faker->date(DateTimeFormat::YYYY_MM_DD_H_I_S));
        $this->setEndDate(null);
        $this->shouldThrow(ErrorParameter::class)->duringPublicValidateGroupRequirements();

        $this->setStartDate(null);
        $this->setEndDate($this->faker->date(DateTimeFormat::YYYY_MM_DD_H_I_S));
        $this->shouldThrow(ErrorParameter::class)->duringPublicValidateGroupRequirements();
    }

    public function it_should_not_throw_when_date_max_difference_with_valid_requirements()
    {
        $this->setStartDate('1970-12-12');
        $this->setEndDate('1970-12-19');

        $this->shouldNotThrow()->duringPublicValidateDatesMaxDifference(7);
    }

    public function it_should_throw_when_date_max_difference_with_invalid_requirements()
    {
        $this->setStartDate('1970-12-12');
        $this->setEndDate('1970-12-20');

        $this->shouldThrow(ErrorParameter::class)->duringPublicValidateDatesMaxDifference(7);
    }
}
