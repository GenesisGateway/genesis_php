<?php

namespace spec\Genesis\Api\Request\NonFinancial\Fraud\Rdr;

use Genesis\Api\Request\NonFinancial\Fraud\Rdr\DateRange;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Parser;
use PhpSpec\ObjectBehavior;
use spec\Fixtures\Api\Stubs\Parser\ParserStub;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\ScopeSharedExample;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class DateRangeSpec extends ObjectBehavior
{
    use RequestExamples;
    use ScopeSharedExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(DateRange::class);
    }

    public function it_should_fail_when_missing_required_parameter_scope()
    {
        $this->setRequestDateParameters();
        $this->setRequestPageParameters();

        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_return_class_instance_after_set_start_date()
    {
        $this->setStartDate(null)->shouldBeAnInstanceOf(DateRange::class);
        $this->setStartDate(Faker::getInstance()->date('Y-m-d'))
            ->shouldBeAnInstanceOf(DateRange::class);
    }

    public function it_should_fail_when_set_start_date_with_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setStartDate',
            [Faker::getInstance()->date('Ymd')]
        );
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

    public function it_should_fail_when_start_date_bigger_than_end_date()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $startDate = $faker->dateTimeBetween('-6 month', 'now')->format('Y-m-d');
        $endDate   = $faker->dateTimeBetween('-2 years', '-1 years')->format('Y-m-d');

        $this->setStartDate($startDate);
        $this->setEndDate($endDate);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
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

    public function it_should_throw_when_start_date_and_import_date_are_not_set()
    {
        $this->setRequestPageParameters();
        $this->setScopeParameters();
        $this->setStartDate(null);
        $this->setImportDate(null);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_throw_when_start_date_and_import_date_are_set()
    {
        $this->setRequestParameters();
        $this->setImportDate(Faker::getInstance()->date('Y-m-d'));

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_build_structure_with_import_date_only()
    {
        $this->setRequestPageParameters();
        $this->setScopeParameters();
        $this->setStartDate(null);
        $this->setImportDate(Faker::getInstance()->date('Y-m-d'));

        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_not_emit_deprecated_processing_type_param()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotContain('processing_type');
    }

    public function it_should_not_emit_deprecated_externally_processed_param()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotContain('externally_processed');
    }

    public function it_should_not_have_setter_for_deprecated_processing_type()
    {
        $this->shouldThrow()->during('setProcessingType', ['card_present']);
    }

    public function it_should_not_have_setter_for_deprecated_externally_processed()
    {
        $this->shouldThrow()->during('setExternallyProcessed', ['genesis']);
    }

    public function it_should_contain_scope_in_structure()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldContain('<scope>');
    }

    protected function setRequestParameters()
    {
        $this->setRequestDateParameters();
        $this->setRequestPageParameters();
        $this->setScopeParameters();
    }

    /**
     * Default parameters used by the shared scope examples
     *
     * @return void
     */
    protected function setDefaultRequestParameters()
    {
        $this->setRequestParameters();
    }

    protected function setRequestDateParameters()
    {
        $faker = Faker::getInstance();

        $startDate = $faker->dateTimeBetween('-2 years', '-1 month')->format('Y-m-d');
        $endDate   = $faker->dateTimeBetween($startDate, 'now')->format('Y-m-d');

        $this->setStartDate($startDate);
        $this->setEndDate($endDate);
    }

    protected function setRequestPageParameters()
    {
        $this->setPage(1);
        $this->setPerPage(20);
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
        $parser = new ParserStub('NonFinancial\Fraud\Rdr');

        $response->beADoubleOf('Genesis\Api\Response');
        $response->getResponseObject()->willReturn(
            $parser->DateRange('xml', 'response')->getParsedDocument()
        );

        $this->response = $response;
    }

    public function getMatchers(): array
    {
        return [
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
            'contain' => function ($subject, $needle) {
                return strpos((string) $subject, $needle) !== false;
            }
        ];
    }
}
