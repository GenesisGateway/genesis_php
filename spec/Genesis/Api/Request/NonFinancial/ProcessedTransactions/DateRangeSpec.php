<?php

namespace spec\Genesis\Api\Request\NonFinancial\ProcessedTransactions;

use Genesis\Api\Request\NonFinancial\ProcessedTransactions\DateRange;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\DateRangeRequestSharedExample;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\ExternallyProcessedSharedExample;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\ProcessingTypeSharedExample;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class DateRangeSpec extends ObjectBehavior
{
    use DateRangeRequestSharedExample;
    use ExternallyProcessedSharedExample;
    use ProcessingTypeSharedExample;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(DateRange::class);
    }

    public function it_should_containt_request_parameters()
    {
        $this->setDefaultRequestParameters();

        $this->getDocument()->shouldContain('start_date');
        $this->getDocument()->shouldContain('end_date');
        $this->getDocument()->shouldContain('page');
        $this->getDocument()->shouldContain('per_page');
        $this->getDocument()->shouldContain('externally_processed');
        $this->getDocument()->shouldContain('processing_type');
    }

    public function it_should_have_correct_endpoint_url()
    {
        $this->getApiConfig('url')->shouldContain('processed_transactions/by_date');
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
    }

    public function setRequestParameters()
    {
        $this->setRequestDateParameters();
        $this->setEndDate(null);
    }
}
