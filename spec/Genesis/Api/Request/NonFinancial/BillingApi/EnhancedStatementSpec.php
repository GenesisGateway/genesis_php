<?php

namespace spec\Genesis\Api\Request\NonFinancial\BillingApi;

use Genesis\Api\Request\NonFinancial\BillingApi\EnhancedStatement;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\BillingApi\DateTimeFromToAttributesSharedExample;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\BillingApi\OrderByDirectionSharedExample;

class EnhancedStatementSpec extends ObjectBehavior
{
    use DateTimeFromToAttributesSharedExample;
    use OrderByDirectionSharedExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(EnhancedStatement::class);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotBeEmpty();
        $this->getDocument()->shouldContain('enhancedBillingStatements');
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_render_master_account_mid()
    {
        $this->setRequestParameters();
        $this->setMasterAccountMID(['MID001', 'MID002']);

        $this->getDocument()->shouldContain('masterAccountMID: [\"MID001\",\"MID002\"]');
    }

    public function it_should_fail_with_invalid_number_of_master_account_mid()
    {
        $values = array_fill(0, 1001, 'MID');

        $this->setRequestParameters();
        $this->setMasterAccountMID($values);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_escape_breaking_symbols_in_list_filter()
    {
        $this->setBillingStatement(['A"B', 'C\\D']);
        $this->getBillingStatement()->shouldReturn('["A\\"B","C\\\\D"]');
    }

    public function it_should_render_caller_provided_summary_tree()
    {
        $this->setResponseFields([
            'summary' => [
                'grossVolume' => ['count', 'amount'],
                'netSettlementAmount',
            ],
        ]);
        $this->setStatus('paid');

        $this->getDocument()->shouldContain('summary { grossVolume { count amount } netSettlementAmount }');
    }

    public function it_should_render_caller_provided_details_tree()
    {
        $this->setResponseFields([
            'details' => [
                'discountFees' => [
                    'subtotalCount',
                    'feesByRegionAndCardType' => ['category', 'feesByTransactionType' => ['transactionType']],
                ],
            ],
        ]);
        $this->setStatus('paid');

        $this->getDocument()->shouldContain('details { discountFees { subtotalCount');
        $this->getDocument()->shouldContain('feesByRegionAndCardType { category feesByTransactionType { transactionType } }');
    }

    public function it_should_render_pricing_method()
    {
        $this->setResponseFields(['billingStatement', 'pricingMethod']);
        $this->setStatus('paid');

        $this->getDocument()->shouldContain('pricingMethod');
    }

    public function it_should_render_only_requested_nested_fields()
    {
        $this->setResponseFields(['details' => ['discountFees' => ['subtotalCount']]]);
        $this->setStatus('paid');

        $this->getDocument()->shouldContain('details { discountFees { subtotalCount } }');
        $this->getDocument()->shouldNotContain('transactionFees');
    }

    public function it_should_throw_on_empty_nested_selection()
    {
        $this->setResponseFields(['details' => []]);
        $this->setStatus('paid');

        $this->shouldThrow(InvalidArgument::class)->during('getDocument');
    }

    public function it_should_throw_on_unknown_top_level_field()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setResponseFields', [['unknownField']]);
    }

    public function it_should_not_validate_unknown_nested_field()
    {
        $this->setResponseFields(['details' => ['discountFees' => ['madeUpNestedField']]]);
        $this->setStatus('paid');

        $this->getDocument()->shouldContain('madeUpNestedField');
    }

    public function it_should_have_cursor_paging()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldContain('paging {');
    }

    protected function setRequestParameters()
    {
        $this->setResponseFields(['id', 'billingStatement', 'status', 'summary', 'details']);
        $this->setStatus('paid');
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
