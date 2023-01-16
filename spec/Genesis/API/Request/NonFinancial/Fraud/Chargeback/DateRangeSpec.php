<?php

namespace spec\Genesis\API\Request\NonFinancial\Fraud\Chargeback;

use Genesis\API\Constants\NonFinancial\Fraud\Chargeback\ExternallyProcessed;
use Genesis\API\Constants\NonFinancial\Fraud\Chargeback\ProcessingTypes;
use Genesis\API\Request\NonFinancial\Fraud\Chargeback\DateRange;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\API\Response as Response;
use Genesis\Parser;
use PhpSpec\ObjectBehavior;
use spec\fixtures\API\Stubs\Parser\ParserStub;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\NonFinancial\DateRangeRequestSharedExample;
use spec\SharedExamples\Genesis\API\Request\NonFinancial\ExternallyProcessedSharedExample;
use spec\SharedExamples\Genesis\API\Request\NonFinancial\ProcessingTypeSharedExample;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class DateRangeSpec extends ObjectBehavior
{
    use RequestExamples, DateRangeRequestSharedExample, ExternallyProcessedSharedExample,
        ProcessingTypeSharedExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(DateRange::class);
    }

    public function it_should_fail_when_missing_required_parameter_start_date()
    {
        $this->testMissingRequiredParameters([
            'start_date'
        ]);
    }

    public function it_should_fail_when_missing_required_parameter_import_date()
    {
        $this->setRequestParameters();
        $this->setImportDate(Faker::getInstance()->date('Y-m-d'));
        $this->setStartDate(null);

        $this->setImportDate(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_return_class_instance_after_set_start_date()
    {
        $this->setStartDate(null)->shouldBeAnInstanceOf(DateRange::class);
        $this->setStartDate(Faker::getInstance()->date('Y-m-d'))
            ->shouldBeAnInstanceOf(DateRange::class);
    }

    public function it_should_fail_when_set_end_date_with_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setEndDate',
            [Faker::getInstance()->date('Ymd')]
        );
    }

    public function it_should_be_string_end_date()
    {
        $this->setEndDate(Faker::getInstance()->date('Y-m-d'));
        $this->getEndDate()->shouldBeString();
    }

    public function it_should_be_null_when_unset_end_date()
    {
        $this->setEndDate(null);
        $this->getEndDate()->shouldBeNull();
    }

    public function it_should_throw_when_start_date_and_import_date_are_not_set()
    {
        $this->setStartDate(null);
        $this->setImportDate(null);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_have_type_date_range_when_use_set_end_date()
    {
        $this->setEndDate(null)->shouldBeAnInstanceOf(DateRange::class);
        $this->setEndDate('2012-12-12')->shouldBeAnInstanceOf(DateRange::class);
    }

    public function it_should_fail_when_set_import_date_with_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setImportDate',
            [Faker::getInstance()->date('Ymd')]
        );
    }

    public function it_should_be_string_import_date()
    {
        $this->setImportDate(Faker::getInstance()->date('Y-m-d'));
        $this->getImportDate()->shouldBeString();
    }

    public function it_should_be_null_when_unset_import_date()
    {
        $this->setImportDate(null);
        $this->getImportDate()->shouldBeNull();
    }

    public function it_should_have_type_date_range_when_use_set_import_date()
    {
        $this->setEndDate(null)->shouldBeAnInstanceOf(DateRange::class);
        $this->setEndDate('2012-12-12')->shouldBeAnInstanceOf(DateRange::class);
    }

    public function it_should_throw_when_start_date_and_import_date_are_set()
    {
        $this->setRequestParameters();
        $this->setImportDate(Faker::getInstance()->date('Y-m-d'));

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $this->setRequestDateParameters();
        $this->setRequestPageParameters();
        $this->setRequestAdditionalParameters();
    }

    public function it_should_have_the_proper_root_node_attributes_structure($response)
    {
        $this->prepareResponseMock($response);

        $this->response->getResponseObject()->{Parser::SUMMARY_TREE_NODE}->shouldHaveType('\stdClass');
    }

    public function it_should_have_the_proper_root_node_attributes_values($response)
    {
        $this->prepareResponseMock($response);

        $this->response->getResponseObject()->{Parser::SUMMARY_TREE_NODE}->page->shouldBe("1");

        $this->response->getResponseObject()->{Parser::SUMMARY_TREE_NODE}->per_page->shouldBe("100");

        $this->response->getResponseObject()->{Parser::SUMMARY_TREE_NODE}->total_count->shouldBe("12");

        $this->response->getResponseObject()->{Parser::SUMMARY_TREE_NODE}->pages_count->shouldBe("1");
    }

    protected function prepareResponseMock($response)
    {
        $parser = new ParserStub('NonFinancial\Fraud\Chargeback');

        $response->beADoubleOf('Genesis\API\Response');
        $response->getResponseObject()->willReturn(
            $parser->DateRange('xml', 'response')->getParsedDocument()
        );

        $this->response = $response;
    }

    /**
     * Helpers
     */

    /**
     * Set Additional Parameters
     *
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    protected function setRequestAdditionalParameters()
    {
        $this->setExternallyProcessedParameters();
        $this->setProcessingTypeParameters();
    }
}
