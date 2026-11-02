<?php

namespace spec\SharedExamples\Genesis\Api\Request\NonFinancial\BillingApi;

use Genesis\Exceptions\ErrorParameter;

/**
 * Trait DateTimeFromToAttributesSharedExample
 *
 * Shared spec examples for the DateTimeFromToAttributes trait (startDateFrom/startDateTo and
 * endDateFrom/endDateTo range filters), reused by every request spec that composes the trait.
 * The host spec must provide a setRequestParameters() helper that seeds a valid request.
 *
 * @package spec\SharedExamples\Genesis\Api\Request\NonFinancial\BillingApi
 */
trait DateTimeFromToAttributesSharedExample
{
    public function it_should_set_start_date_range_filters()
    {
        $this->setRequestParameters();
        $this->setStartDateFrom('2024-01-01');
        $this->setStartDateTo('2024-01-07');

        $this->shouldNotThrow()->during('getDocument');
        $this->getDocument()->shouldContain('startDateFrom');
        $this->getDocument()->shouldContain('startDateTo');
    }

    public function it_should_set_end_date_range_filters()
    {
        $this->setRequestParameters();
        $this->setEndDateFrom('2024-01-01');
        $this->setEndDateTo('2024-01-07');

        $this->shouldNotThrow()->during('getDocument');
        $this->getDocument()->shouldContain('endDateFrom');
        $this->getDocument()->shouldContain('endDateTo');
    }

    public function it_should_allow_exactly_seven_days_difference()
    {
        $this->setRequestParameters();
        $this->setStartDateFrom('2024-01-01');
        $this->setStartDateTo('2024-01-08'); // exactly 7 days

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_throw_when_max_days_difference_exceeded()
    {
        $this->setRequestParameters();
        $this->setStartDateFrom('2024-01-01');
        $this->setStartDateTo('2024-01-09'); // 8 days > 7 max

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_throw_when_date_range_reversed()
    {
        $this->setRequestParameters();
        $this->setStartDateFrom('2024-01-07');
        $this->setStartDateTo('2024-01-01'); // from after to

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_start_date_from_and_missing_start_date_to()
    {
        $this->setRequestParameters();
        $this->setStartDateFrom('2024-01-01');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_start_date_to_and_missing_start_date_from()
    {
        $this->setRequestParameters();
        $this->setStartDateTo('2024-01-01');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_end_date_from_and_missing_end_date_to()
    {
        $this->setRequestParameters();
        $this->setEndDateFrom('2024-01-01');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_end_date_to_and_missing_end_date_from()
    {
        $this->setRequestParameters();
        $this->setEndDateTo('2024-01-01');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_render_date_only_after_replacing_datetime_with_date()
    {
        $this->setStartDateFrom('2024-01-01 10:30:00');
        $this->setStartDateFrom('2024-01-01');

        $this->getStartDateFrom()->shouldReturn('2024-01-01');
    }
}
