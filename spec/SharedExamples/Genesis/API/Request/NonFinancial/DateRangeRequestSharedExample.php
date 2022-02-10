<?php

namespace spec\SharedExamples\Genesis\API\Request\NonFinancial;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Request\NonFinancial\Fraud\Chargeback\DateRange;
use Genesis\Exceptions\ErrorParameter;
use spec\SharedExamples\Faker;

/**
 * Trait DateRangeRequestSharedExample
 * @package spec\SharedExamples\Genesis\API\Request\NonFinancial
 */
trait DateRangeRequestSharedExample
{

    public function it_should_fail_without_required_parameters()
    {
        $this->setRequestParameters();
        $this->testMissingRequiredParameter('start_date');
    }

    public function it_should_fail_when_startDate_bigger_than_endDate()
    {
        $faker = Faker::getInstance();
        $this->setRequestParameters();

        $startDate = $faker->dateTimeBetween('-6 month', 'now')
            ->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
        $endDate   = $faker->dateTimeBetween('-2 years', '-1 years')
            ->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);

        $this->setStartDate($startDate);
        $this->setEndDate($endDate);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    /**
     * Set Request Dates for Request
     *
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    protected function setRequestDateParameters()
    {
        $faker = Faker::getInstance();

        $startDate = $faker->dateTimeBetween('-2 years', '-1 month')
            ->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);
        $endDate   = $faker->dateTimeBetween($startDate, 'now')
            ->format(DateTimeFormat::YYYY_MM_DD_ISO_8601);

        $this->setStartDate($startDate);
        $this->setEndDate($endDate);
    }

    /**
     * Set Request Page attributes for Request
     */
    protected function setRequestPageParameters()
    {
        $this->setPage(1);
        $this->setPerPage(20);
    }
}
