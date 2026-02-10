<?php

namespace spec\Genesis\Api\Request\NonFinancial\BillingApi;

use Genesis\Api\Request\NonFinancial\BillingApi\Statement;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\BillingApi\OrderByDirectionSharedExample;

class StatementSpec extends ObjectBehavior
{
    use OrderByDirectionSharedExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Statement::class);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotBeEmpty();
        $this->getDocument()->shouldContain('billingStatements');
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_set_request_filters()
    {
        $this->setRequestParameters();
        $this->setBillingStatement(['STMT001']);
        $this->setStatus('paid');
        $this->setCurrency('EUR');
        $this->setPaymentMethod('Credit Card');
        $this->setCreationDate('2024-01-01');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_set_date_range_filters()
    {
        $this->setRequestParameters();
        $this->setStartDate('2024-01-01');
        $this->setEndDate('2024-01-07');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_throw_when_max_days_difference_exceeded()
    {
        $this->setRequestParameters();
        $this->setStartDate('2024-01-01');
        $this->setEndDate('2024-01-09'); // 8 days > 7 max

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_start_date_and_missing_end_date()
    {
        $this->setRequestParameters();
        $this->setStartDate('2024-01-01');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_end_date_and_missing_start_date()
    {
        $this->setRequestParameters();
        $this->setEndDate('2024-01-01');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_number_of_billing_statement_ids()
    {
        $values = array_fill(0, 1001, 'STMT'); // 1001 > 1000 max

        $this->setRequestParameters();
        $this->setBillingStatement($values);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_response_field()
    {
        $this->setRequestParameters();

        $this->shouldThrow(InvalidArgument::class)->during('setResponseFields', ['invalid_field']);
    }

    public function it_should_fail_with_invalid_status()
    {
        $this->setRequestParameters();

        $this->shouldThrow(InvalidArgument::class)->during('setStatus', ['invalid_status']);
    }

    public function it_should_set_valid_status()
    {
        $this->setRequestParameters();
        
        $this->setStatus('paid');
        $this->setStatus('pending');
        $this->setStatus('open');
        $this->setStatus('bounced');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_set_order_by_field()
    {
        $this->setRequestParameters();

        $this->setOrderByField($this->getOrderByFieldAllowedValues());

        $this->getDocument()->shouldContain('byField');
    }

    public function it_should_fail_with_invalid_order_by_field()
    {
        $this->setRequestParameters();

        $this->shouldThrow(InvalidArgument::class)->during('setOrderByField', ['invalid_field']);
    }

    public function it_should_have_paging()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldContain('paging {');
    }

    public function it_should_set_cursor_pagination_parameters()
    {
        $this->setRequestParameters();
        $this->setPerPage(50);
        $this->setNext('cursor_value');

        $this->getDocument()->shouldContain('perPage');
        $this->getDocument()->shouldContain('next');
    }

    public function it_should_set_currency()
    {
        $this->setRequestParameters();
        $this->setCurrency('USD');
        
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_with_invalid_currency()
    {
        $this->setRequestParameters();
        
        $this->shouldThrow(InvalidArgument::class)->during('setCurrency', ['INVALID']);
    }

    public function it_should_set_creation_date()
    {
        $this->setRequestParameters();
        $this->setCreationDate('2024-01-01');
        
        $this->getCreationDate()->shouldReturn('2024-01-01');
    }

    public function it_should_format_complex_fields()
    {
        $this->setResponseFields(['summary', 'details']);
        $this->setStatus('paid');
        
        $this->getDocument()->shouldContain('summary { grossVolume debit credit fees');
        $this->getDocument()->shouldContain('details { transactionTypesBreakdown');
    }

    public function it_should_format_status_without_quotes()
    {
        $this->setRequestParameters();
        $this->setStatus('paid');

        $this->getDocument()->shouldContain('status: paid');
        $this->getDocument()->shouldNotContain('status: "paid"');
    }

    public function it_should_include_summary_in_response_structure()
    {
        $this->setResponseFields(['billingStatement', 'startDate', 'paymentMethod', 'masterAccountName', 'creationDate', 'summary']);
        $this->setStatus('paid');

        $this->getDocument()->shouldContain('summary { grossVolume debit credit fees taxes netReserves adjustments netSettlementAmount paymentFxConversionFee paymentAmount paymentCurrency }');
    }

    public function it_should_set_billing_statement()
    {
        $this->setRequestParameters();
        $this->setBillingStatement(['STMT001', 'STMT002']);
        $this->getBillingStatement()->shouldReturn('["STMT001","STMT002"]');
    }

    protected function setRequestParameters()
    {
        $this->setResponseFields($this->getResponseFieldsAllowedValues());
        $this->setStatus('paid');
    }

    private function getOrderByFieldAllowedValues()
    {
        $faker = Faker::getInstance();

        $values = ['billingStatement', 'creationDate', 'startDate', 'endDate', 'valueDate', 
                  'currency', 'status', 'masterAccountName'];

        return $faker->randomElement($values);
    }

    private function getResponseFieldsAllowedValues()
    {
        $faker = Faker::getInstance();

        $values = ['id', 'billingStatement', 'status', 'company', 'masterAccountName', 
                  'masterAccountCurrency', 'valueDate', 'creationDate', 'currency', 
                  'paymentMethod', 'startDate', 'endDate', 'summary', 'details'];

        return $faker->randomElements($values, 5);
    }

    public function getMatchers(): array
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            }
        );
    }
}
