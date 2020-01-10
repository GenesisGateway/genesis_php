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
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class DateRangeSpec extends ObjectBehavior
{
    use RequestExamples;

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
        $this->setImportDate('2012-12-12');
        $this->setStartDate(null);

        $this->setImportDate(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_set_start_date_with_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setStartDate',
            ['12.12.2012']
        );
    }

    public function it_should_be_string_start_date()
    {
        $this->setStartDate('2012-12-12');
        $this->getStartDate()->shouldBeString();
    }

    public function it_should_be_null_when_unset_start_date()
    {
        $this->setStartDate(null);
        $this->getStartDate()->shouldBeNull();
    }

    public function it_should_have_type_date_range_when_use_set_start_date()
    {
        $this->setStartDate(null)->shouldBeAnInstanceOf(DateRange::class);
        $this->setStartDate('2012-12-12')->shouldBeAnInstanceOf(DateRange::class);
    }

    public function it_should_fail_when_set_end_date_with_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setEndDate',
            ['12.12.2012']
        );
    }

    public function it_should_be_string_end_date()
    {
        $this->setEndDate('2012-12-12');
        $this->getEndDate()->shouldBeString();
    }

    public function it_should_be_null_when_unset_end_date()
    {
        $this->setEndDate(null);
        $this->getEndDate()->shouldBeNull();
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
            ['12.12.2012']
        );
    }

    public function it_should_be_string_import_date()
    {
        $this->setImportDate('2012-12-12');
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
        $this->setImportDate('2012-12-12');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_be_int_get_page_parameter()
    {
        $this->setPage('1');
        $this->getPage()->shouldBeInt();

        $this->setPage(null);
        $this->getPage()->shouldBeInt();
    }

    public function it_should_be_int_get_per_page_parameter()
    {
        $this->setPerPage('1');
        $this->getPerPage()->shouldBeInt();

        $this->setPerPage(null);
        $this->getPerPage()->shouldBeInt();
    }

    public function it_should_not_fail_when_valid_externally_processed()
    {
        $this->shouldNotThrow()->during(
            'setExternallyProcessed',
            [
                $this->getRandomExternallyProcessed()
            ]
        );
    }

    public function it_should_fail_when_invalid_externally_processed()
    {
        $this->shouldThrow()->during(
            'setExternallyProcessed',
            [
                'ttt'
            ]
        );
    }

    public function it_should_not_fail_when_valid_processing_type()
    {
        $this->shouldNotThrow()->during(
            'setProcessingType',
            [
                $this->getRandomProcessingType()
            ]
        );
    }

    public function it_should_fail_when_invalid_processing_type()
    {
        $this->shouldThrow()->during(
            'setProcessingType',
            [
                'ttt'
            ]
        );
    }

    public function it_should_fail_when_startDate_bigger_than_endDate()
    {
        $faker = $this->getFaker();
        $this->setRequestParameters();

        $startDate = $faker->dateTimeBetween('-6 month', 'now')->format(DateRange::DATE_FORMAT);
        $endDate = $faker->dateTimeBetween('-2 years', '-1 years')->format(DateRange::DATE_FORMAT);

        $this->setStartDate($startDate);
        $this->setEndDate($endDate);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_fail_when_request_only_start_date()
    {
        $faker = $this->getFaker();
        $this->setStartDate(
            $faker->dateTimeBetween('-2 years', '-1 month')->format(DateRange::DATE_FORMAT)
        );

        $this->shouldNotThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $this->setRequestDateParameters();
        $this->setRequestPageParameters();
        $this->setRequestAdditionalParameters();
    }

    /*
     * Helpers
     */

    /**
     * Set Request Dates for Request
     *
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    protected function setRequestDateParameters()
    {
        $faker = $this->getFaker();

        $startDate = $faker->dateTimeBetween('-2 years', '-1 month')->format(DateRange::DATE_FORMAT);
        $endDate = $faker->dateTimeBetween($startDate, 'now')->format(DateRange::DATE_FORMAT);

        $this->setStartDate($startDate);
        $this->setEndDate($endDate);
    }

    /**
     * Set Request Page attributes for Request
     */
    protected function setRequestPageParameters()
    {
        $this->setPage(1);
        $this->setPerPage(20);
    }

    /**
     * Set Additional Parameters
     *
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    protected function setRequestAdditionalParameters()
    {
        $this->setExternallyProcessed($this->getRandomExternallyProcessed());
        $this->setProcessingType($this->getRandomProcessingType());
    }

    /**
     * Random Externally Processed attribute value
     *
     * @return string
     */
    protected function getRandomExternallyProcessed()
    {
        $externallyProcessed = ExternallyProcessed::getAll();

        return $externallyProcessed[array_rand($externallyProcessed)];
    }

    /**
     * Random Processing Type
     *
     * @return string
     */
    protected function getRandomProcessingType()
    {
        $processingType = ProcessingTypes::getAll();

        return $processingType[array_rand($processingType)];
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
}
