<?php

namespace spec\Genesis\Api\Request\NonFinancial\PaymentAuthorizations;

use Genesis\Api\Request\NonFinancial\PaymentAuthorizations\DateRange;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\DateRangeRequestSharedExample;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\ScopeSharedExample;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class DateRangeSpec extends ObjectBehavior
{
    use DateRangeRequestSharedExample;
    use RequestExamples;
    use ScopeSharedExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(DateRange::class);
    }

    public function it_should_have_correct_endpoint_url()
    {
        $this->getApiConfig('url')->shouldMatch('/\/payment_authorizations\/by_date$/');
    }

    public function it_should_contain_correct_parent_node()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldContain('payment_authorization_request');
    }

    public function it_should_contain_request_parameters()
    {
        $this->setDefaultRequestParameters();

        $this->getDocument()->shouldContain('start_date');
        $this->getDocument()->shouldContain('end_date');
        $this->getDocument()->shouldContain('auth_start_date');
        $this->getDocument()->shouldContain('auth_end_date');
        $this->getDocument()->shouldContain('page');
        $this->getDocument()->shouldContain('per_page');
        $this->getDocument()->shouldContain('scope');
        $this->getDocument()->shouldNotContain('externally_processed');
        $this->getDocument()->shouldNotContain('processing_type');
    }

    public function it_should_not_fail_with_correct_auth_dates()
    {
        $this->shouldNotThrow()->during('setAuthStartDate', [Faker::getInstance()->date('Y-m-d')]);
        $this->shouldNotThrow()->during('setAuthStartDate', [Faker::getInstance()->date('d.m.Y')]);
        $this->shouldNotThrow()->during('setAuthEndDate', [Faker::getInstance()->date('Y-m-d')]);
        $this->shouldNotThrow()->during('setAuthEndDate', [Faker::getInstance()->date('d.m.Y')]);
    }

    public function it_should_fail_with_invalid_auth_dates()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setAuthStartDate', [Faker::getInstance()->date('Ymd')]);
        $this->shouldThrow(InvalidArgument::class)
            ->during('setAuthEndDate', [Faker::getInstance()->date('Ymd')]);
    }

    public function it_should_return_auth_dates_in_gateway_format()
    {
        $this->setAuthStartDate('2024-03-10 13:45:00');
        $this->setAuthEndDate('15.03.2024');

        $this->getAuthStartDate()->shouldBe('2024-03-10');
        $this->getAuthEndDate()->shouldBe('2024-03-15');
    }

    public function it_should_clear_auth_dates_with_empty_value()
    {
        $this->setRequestParameters();
        $this->setAuthStartDate('2024-03-10');
        $this->setAuthEndDate('2024-03-15');

        $this->setAuthStartDate(null);
        $this->setAuthEndDate('');

        $this->getAuthStartDate()->shouldBe(null);
        $this->getAuthEndDate()->shouldBe(null);
        $this->getDocument()->shouldNotContain('auth_start_date');
        $this->getDocument()->shouldNotContain('auth_end_date');
    }

    public function it_should_not_fail_with_auth_start_date_only()
    {
        $this->setRequestParameters();
        $this->setStartDate(null);
        $this->setAuthStartDate('2024-03-10');

        $this->getDocument()->shouldContain('<auth_start_date>2024-03-10</auth_start_date>');
        $this->getDocument()->shouldNotContain('<start_date>');
    }

    public function it_should_fail_when_auth_start_date_bigger_than_auth_end_date()
    {
        $this->setRequestParameters();
        $this->setAuthStartDate('2024-03-15');
        $this->setAuthEndDate('2024-03-10');

        $this->shouldThrow(
            new ErrorParameter('Auth end date must be greater than or equal to the auth start date')
        )->during('getDocument');
    }

    public function it_should_not_fail_with_equal_dates()
    {
        $this->setRequestParameters();
        $this->setStartDate('2024-03-10');
        $this->setEndDate('2024-03-10');
        $this->setAuthStartDate('2024-03-10');
        $this->setAuthEndDate('2024-03-10');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_with_equal_auth_dates_set_in_reverse_order()
    {
        $this->setRequestParameters();
        $this->setAuthEndDate('2024-03-10 08:00:00');
        $this->setAuthStartDate('2024-03-10 18:00:00');

        $this->shouldNotThrow()->during('getDocument');
        $this->getDocument()->shouldContain('<auth_start_date>2024-03-10</auth_start_date>');
        $this->getDocument()->shouldContain('<auth_end_date>2024-03-10</auth_end_date>');
    }

    public function it_should_fail_when_both_start_date_and_auth_start_date_are_missing()
    {
        $this->setRequestParameters();
        $this->setStartDate(null);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_fail_with_end_dates_without_start_dates()
    {
        $this->setRequestParameters();
        $this->setAuthEndDate('2024-03-10');

        $this->getDocument()->shouldContain('<auth_end_date>2024-03-10</auth_end_date>');

        $this->setStartDate(null);
        $this->setAuthStartDate('2024-03-01');
        $this->setAuthEndDate(null);
        $this->setEndDate('2024-03-10');

        $this->getDocument()->shouldContain('<end_date>2024-03-10</end_date>');
    }

    public function it_should_fail_without_scope()
    {
        $this->setRequestParameters();
        $this->testMissingRequiredParameter('scope');
    }

    public function it_should_contain_per_page_parameter_at_maximum()
    {
        $this->setRequestParameters();
        $this->setPerPage(DateRange::MAX_PER_PAGE);

        $this->getDocument()->shouldContain('<per_page>500</per_page>');
    }

    public function it_should_fail_when_per_page_exceeds_maximum()
    {
        $this->setRequestParameters();
        $this->setPerPage(DateRange::MAX_PER_PAGE + 1);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_omit_paging_parameters_when_zero()
    {
        $this->setRequestParameters();
        $this->setPage(0);
        $this->setPerPage(0);

        $this->getDocument()->shouldNotContain('<page>');
        $this->getDocument()->shouldNotContain('<per_page>');
    }

    protected function setRequestParameters()
    {
        $this->setStartDate($this->getFaker()->dateTimeBetween('-2 years', '-1 month')->format('Y-m-d'));
        $this->setScopeParameters();
    }

    protected function setDefaultRequestParameters()
    {
        $this->setRequestDateParameters();
        $this->setRequestPageParameters();
        $this->setAuthStartDate('2024-03-01');
        $this->setAuthEndDate('2024-03-31');
        $this->setScopeParameters();
    }
}
