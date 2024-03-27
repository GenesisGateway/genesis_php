<?php

namespace spec\Genesis\API\Request\NonFinancial\BillingApi;

use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\API\Request\NonFinancial\BillingApi\Transaction;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\NonFinancial\BillingApi\OrderByDirectionSharedExample;

class TransactionSpec extends ObjectBehavior
{
    use OrderByDirectionSharedExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Transaction::class);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotBeEmpty();
        $this->getDocument()->shouldContain('billingTransactions');
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_missing_required_filters()
    {
        $this->setRequestParameters();
        $this->setUniqueId(null);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }
    public function it_should_set_request_filters()
    {
        $this->setRequestParameters();
        $this->setBillingStatementId(['123']);
        $this->setStartDate('2024-05-01');
        $this->setEndDate('2024-05-10');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_with_start_date_and_missing_end_date()
    {
        $this->setRequestParameters();
        $this->setStartDate('2025-05-01');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_end_date_and_missing_start_date()
    {
        $this->setRequestParameters();
        $this->setEndDate('2025-05-01');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_number_of_billing_statement_ids()
    {
        $values = array_fill(0, 15, '100');

        $this->setRequestParameters();
        $this->setBillingStatementId($values);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_response_field()
    {
        $this->setRequestParameters();

        $this->shouldThrow(InvalidArgument::class)->during('setResponseFields', ['invalid_value']);
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

        $this->shouldThrow(InvalidArgument::class)->during('setOrderByField', ['invalid_value']);
    }

    public function it_should_have_paging()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldContain('paging {');
    }

    protected function setRequestParameters()
    {
        $this->setResponseFields($this->getResponseFieldsAllowedValues());
        $this->setUniqueId('unique_id');
    }

    private function getOrderByFieldAllowedValues()
    {
        $faker = Faker::getInstance();

        $values = ['billingStatementId', 'transactionDate', 'transactionCurrency', 'transactionAmount',
            'terminalId', 'exchangeRate', 'billingAmount', 'transactionFeeAmount', 'commissionPercent',
            'commissionAmount', 'commissionRuleId', 'interchangeFee', 'region', 'settlementStatus'];

        return $faker->randomElement($values);
    }

    private function getResponseFieldsAllowedValues()
    {
        $faker = Faker::getInstance();

        $values = ['uniqueId', 'billingStatementId', 'billingStatementDisplayId', 'transactionType',
            'transactionDate', 'transactionCurrency', 'transactionAmount', 'exchangeRate', 'billingCurrency',
            'billingAmount', 'transactionFeeCurrency', 'transactionFeeAmount', 'commissionAmount', 'commissionRuleId',
            'transactionFeeChargedOnBillingStatementId', 'commissionPercent',  'interchangeFee', 'interchangeCurrency',
            'isInterchangeplusplus', 'interchangeplusplusChargedOnBillingStatementId', 'schemeFee', 'vatAmount',
            'vatRate', 'schemeFeeCurrency', 'standardDebitCardRate', 'gstAmount', 'gstRate', 'terminalId', 'region',
            'settlementStatements', 'settlementDates', 'settlementStatus', 'merchantId', 'merchantName', 'valueDate'];

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
