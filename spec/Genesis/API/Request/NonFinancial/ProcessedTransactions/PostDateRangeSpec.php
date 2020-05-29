<?php

namespace spec\Genesis\API\Request\NonFinancial\ProcessedTransactions;

use Genesis\API\Request\NonFinancial\ProcessedTransactions\PostDateRange;
use Genesis\Config;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\NonFinancial\DateRangeRequestSharedExample;
use spec\SharedExamples\Genesis\API\Request\NonFinancial\ExternallyProcessedSharedExample;
use spec\SharedExamples\Genesis\API\Request\NonFinancial\ProcessingTypeSharedExample;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class PostDateRangeSpec extends ObjectBehavior
{
    use RequestExamples, DateRangeRequestSharedExample, ExternallyProcessedSharedExample,
    ProcessingTypeSharedExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(PostDateRange::class);
    }

    public function it_should_contain_request_parameters()
    {
        $this->setDefaultRequestParameters();

        $this->getDocument()->shouldContain('start_date');
        $this->getDocument()->shouldContain('end_date');
        $this->getDocument()->shouldContain('page');
        $this->getDocument()->shouldContain('per_page');
        $this->getDocument()->shouldContain('externally_processed');
        $this->getDocument()->shouldContain('processing_type');
        $this->getDocument()->shouldContain('batch_number');
        $this->getDocument()->shouldContain('batch_slip_number');
        $this->getDocument()->shouldContain('deposit_slip_number');
    }

    public function it_should_have_correct_endpoint_url()
    {
        $this->getApiConfig('url')->shouldContain('processed_transactions/by_post_date');
    }

    public function it_should_contain_correct_parent_node()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldContain('processed_transaction_request');
    }

    public function setDefaultRequestParameters()
    {
        $this->setRequestDateParameters();
        $this->setRequestPageParameters();
        $this->setExternallyProcessedParameters();
        $this->setProcessingTypeParameters();
        $this->setBatchNumber('batch_number');
        $this->setBatchSlipNumber('batch_slip_number');
        $this->setDepositSlipNumber('deposit_slip_number');
    }

    public function setRequestParameters()
    {
        $this->setRequestDateParameters();
        $this->setEndDate(null);
    }
}
