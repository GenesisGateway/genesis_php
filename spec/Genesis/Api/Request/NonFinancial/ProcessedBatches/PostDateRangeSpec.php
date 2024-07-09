<?php

namespace spec\Genesis\Api\Request\NonFinancial\ProcessedBatches;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Request\NonFinancial\ProcessedBatches\PostDateRange;
use Genesis\Config;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\DateRangeRequestSharedExample;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class PostDateRangeSpec extends ObjectBehavior
{
    use DateRangeRequestSharedExample;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(PostDateRange::class);
    }

    public function it_should_fail_with_incorrect_endpoint()
    {
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->shouldThrow(InvalidArgument::class)->during('__construct');
    }

    public function it_should_contain_request_parameters()
    {
        Config::setEndpoint(Endpoints::ECOMPROCESSING);

        $this->setDefaultRequestParameters();

        $this->getDocument()->shouldContain('start_date');
        $this->getDocument()->shouldContain('end_date');
        $this->getDocument()->shouldContain('page');
        $this->getDocument()->shouldContain('per_page');
        $this->getDocument()->shouldContain('batch_slip_number');
    }

    public function it_should_have_correct_endpoint_url()
    {
        $this->getApiConfig('url')->shouldContain('processed_batches/by_post_date');
    }

    public function it_should_contain_correct_parent_node()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldContain('processed_batch_request');
    }

    public function setDefaultRequestParameters()
    {
        $this->setRequestDateParameters();
        $this->setRequestPageParameters();
        $this->setBatchSlipNumber('batch_slip_number');
    }

    public function setRequestParameters()
    {
        $this->setRequestDateParameters();
        $this->setEndDate(null);
    }
}
