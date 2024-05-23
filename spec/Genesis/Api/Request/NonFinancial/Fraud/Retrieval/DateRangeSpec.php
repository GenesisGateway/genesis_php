<?php

namespace spec\Genesis\Api\Request\NonFinancial\Fraud\Retrieval;

use Genesis\Api\Request\NonFinancial\Fraud\Retrieval\DateRange;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class DateRangeSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(DateRange::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'start_date'
        ]);
    }

    public function it_should_not_fail_when_set_correct_start_date()
    {
        $this->shouldNotThrow()->during('setStartDate', [Faker::getInstance()->date('Y-m-d')]);
        $this->shouldNotThrow()->during('setStartDate', [Faker::getInstance()->date('d.m.Y')]);
    }

    public function it_should_not_fail_when_set_correct_end_date()
    {
        $this->shouldNotThrow()->during('setEndDate', [Faker::getInstance()->date('Y-m-d')]);
        $this->shouldNotThrow()->during('setEndDate', [Faker::getInstance()->date('d.m.Y')]);
    }

    public function it_should_fail_when_set_invalid_start_date()
    {
        $this->shouldThrow()->during('setStartDate', [Faker::getInstance()->date('Ymd')]);
    }

    public function it_should_fail_when_set_invalid_end_date()
    {
        $this->shouldThrow()->during('setEndDate', [Faker::getInstance()->date('Ymd')]);
    }

    public function it_should_be_string_end_date()
    {
        $this->setEndDate(Faker::getInstance()->date('Y-m-d'))->getEndDate()->shouldBeString();
    }

    public function it_should_be_string_start_date()
    {
        $this->setStartDate(Faker::getInstance()->date('Y-m-d'))->getStartDate()->shouldBeString();
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setStartDate($faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'));
    }
}
