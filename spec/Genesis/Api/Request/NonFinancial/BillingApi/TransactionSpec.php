<?php

namespace spec\Genesis\Api\Request\NonFinancial\BillingApi;

use Genesis\Api\Request\NonFinancial\BillingApi\Transaction;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\BillingApi\OrderByDirectionSharedExample;

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

        $this->shouldThrow(InvalidArgument::class)->during('setUniqueId', [null]);
    }
    public function it_should_set_request_filters()
    {
        $this->setRequestParameters();
        $this->setBillingStatement(['123']);
        $this->setStartDate('2024-05-01');
        $this->setEndDate('2024-05-08');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_throw_when_max_days_difference_with_invalid_values()
    {
        $this->setRequestParameters();
        $this->setStartDate('2024-05-01');
        $this->setEndDate('2024-05-09');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
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
        $this->setBillingStatement($values);

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

    public function it_should_have_billing_statement_with_proper_format()
    {
        $this->setRequestParameters();
        $this->setBillingStatement(['1', 2]);

        $this->getDocument()->shouldContain(' billingStatement: [\"1\",\"2\"] }');
    }

    public function it_should_have_unique_id_with_proper_format()
    {
        $this->setRequestParameters();
        $this->setUniqueId(['1', 2]);

        $this->getDocument()->shouldContain(' uniqueId: [\"1\",\"2\"] }');
    }

    public function it_should_have_merchant_transaction_id_with_proper_format()
    {
        $this->setRequestParameters();
        $this->setMerchantTransactionId(['1', 2]);

        $this->getDocument()->shouldContain(' merchantTransactionId: [\"1\",\"2\"] }');
    }

    public function it_should_have_master_account_name_with_proper_format()
    {
        $this->setRequestParameters();
        $this->setMasterAccountName(['Travis Pastrana']);

        $this->getDocument()->shouldContain(' masterAccountName: [\"Travis Pastrana\"] }');
    }

    protected function setRequestParameters()
    {
        $this->setResponseFields($this->getResponseFieldsAllowedValues());
        $this->setUniqueId(['unique_id']);
    }

    private function getOrderByFieldAllowedValues()
    {
        $faker = Faker::getInstance();

        $values = ['billingStatement', 'transactionDate', 'transactionCurrency', 'transactionAmount', 'exchangeRate',
            'billingAmount', 'transactionFeeAmount', 'commissionPercent', 'commissionAmount', 'interchangeFee',
            'region', 'settlementStatus'];

        return $faker->randomElement($values);
    }

    private function getResponseFieldsAllowedValues()
    {
        $faker = Faker::getInstance();

        $values = ['id', 'uniqueId', 'billingStatement', 'arn', 'transactionType', 'transactionDate',
            'transactionCurrency', 'transactionAmount', 'exchangeRate', 'billingCurrency', 'billingAmount',
            'transactionFeeCurrency', 'transactionFeeAmount', 'transactionFeeChargedOnBillingStatement',
            'commissionPercent', 'commissionAmount', 'interchangeFee', 'interchangeCurrency', 'isInterchangeplusplus',
            'interchangeplusplusChargedOnBillingStatement', 'schemeFee', 'schemeFeeCurrency', 'standardDebitCardRate',
            'gstAmount', 'gstRate', 'vatAmount', 'vatRate', 'terminalName', 'region', 'settlementBillingStatements',
            'settlementDates', 'settlementStatus', 'merchantId', 'merchantName', 'merchantTransactionId',
            'masterAccountName', 'valueDate', 'documentId', 'referenceId', 'authCode', 'paymentType', 'cardBrand',
            'cardNumber', 'cardHolder', 'cardType', 'cardSubtype'];

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
