<?php

namespace spec\Genesis\Api\Request\NonFinancial\Reconcile;

use Genesis\Api\Request\NonFinancial\Reconcile\DateRange;
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

    public function it_should_not_fail_with_correct_start_date()
    {
        $faker = $this->getFaker();
        $dates = [
            $faker->date('Y-m-d H:i:s'),
            $faker->date('Y-m-d'),
            $faker->date('d.m.Y')
        ];

        foreach ($dates as $date) {
            $this->shouldNotThrow()->during('setStartDate', [$date]);
        }
    }

    public function it_should_not_fail_with_correct_end_date()
    {
        $faker = $this->getFaker();
        $dates = [
            $faker->date('Y-m-d H:i:s'),
            $faker->date('Y-m-d'),
            $faker->date('d.m.Y')
        ];

        foreach ($dates as $date) {
            $this->shouldNotThrow()->during('setEndDate', [$date]);
        }
    }

    public function it_should_fail_with_invalid_start_date()
    {
        $faker = $this->getFaker();
        $dates = [
            $faker->date('d.m.Y H:i:s'),
            $faker->date('Ymd'),
        ];

        foreach ($dates as $date) {
            $this->shouldThrow()->during('setStartDate', [$date]);
        }
    }

    public function it_should_fail_with_invalid_end_date()
    {
        $faker = $this->getFaker();
        $dates = [
            $faker->date('d.m.Y H:i:s'),
            $faker->date('Ymd'),
        ];

        foreach ($dates as $date) {
            $this->shouldThrow()->during('setEndDate', [$date]);
        }
    }

    public function it_should_return_string_when_set_start_date()
    {
        $this->setStartDate(Faker::getInstance()->date())->getStartDate()->shouldBeString();
    }

    public function it_should_return_string_when_set_end_date()
    {
        $this->setEndDate(Faker::getInstance()->date())->getEndDate()->shouldBeString();
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setStartDate($faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'));
    }
}
