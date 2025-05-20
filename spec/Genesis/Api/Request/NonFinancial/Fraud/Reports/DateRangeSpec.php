<?php

namespace spec\Genesis\Api\Request\NonFinancial\Fraud\Reports;

use Genesis\Api\Request\NonFinancial\Fraud\Reports\DateRange;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class DateRangeSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(DateRange::class);
    }

    public function it_should_not_fail_with_correct_start_date()
    {
        $this->shouldNotThrow()->during('setStartDate', [Faker::getInstance()->date('Y-m-d')]);
        $this->shouldNotThrow()->during('setStartDate', [Faker::getInstance()->date('d.m.Y')]);
    }

    public function it_should_not_fail_with_correct_end_date()
    {
        $this->shouldNotThrow()->during('setEndDate', [Faker::getInstance()->date('Y-m-d')]);
        $this->shouldNotThrow()->during('setEndDate', [Faker::getInstance()->date('d.m.Y')]);
    }

    public function it_should_not_fail_with_correct_import_date()
    {
        $this->shouldNotThrow()->during('setImportDate', [Faker::getInstance()->date('Y-m-d')]);
        $this->shouldNotThrow()->during('setImportDate', [Faker::getInstance()->date('d.m.Y')]);
    }

    public function it_should_not_fail_with_correct_report_start_date()
    {
        $this->shouldNotThrow()->during('setReportStartDate', [Faker::getInstance()->date('Y-m-d')]);
        $this->shouldNotThrow()->during('setReportStartDate', [Faker::getInstance()->date('d.m.Y')]);
    }

    public function it_should_not_fail_with_correct_report_end_date()
    {
        $this->shouldNotThrow()->during('setReportEndDate', [Faker::getInstance()->date('Y-m-d')]);
        $this->shouldNotThrow()->during('setReportEndDate', [Faker::getInstance()->date('d.m.Y')]);
    }

    public function it_should_fail_with_invalid_start_date()
    {
        $this->shouldThrow()->during('setStartDate', [Faker::getInstance()->date('Ymd')]);
    }

    public function it_should_fail_with_invalid_end_date()
    {
        $this->shouldThrow()->during('setEndDate', [Faker::getInstance()->date('Ymd')]);
    }

    public function it_should_fail_with_invalid_import_date()
    {
        $this->shouldThrow()->during('setImportDate', [Faker::getInstance()->date('Ymd')]);
    }

    public function it_should_fail_with_invalid_report_start_date()
    {
        $this->shouldThrow()->during('setReportStartDate', [Faker::getInstance()->date('Ymd')]);
    }

    public function it_should_fail_with_invalid_report_end_date()
    {
        $this->shouldThrow()->during('setReportEndDate', [Faker::getInstance()->date('Ymd')]);
    }

    public function it_should_be_string_end_date()
    {
        $this->setEndDate(Faker::getInstance()->date('Y-m-d'))->getEndDate()->shouldBeString();
    }

    public function it_should_be_string_start_date()
    {
        $this->setStartDate(Faker::getInstance()->date('Y-m-d'))->getStartDate()->shouldBeString();
    }

    public function it_should_be_string_import_date()
    {
        $this->setImportDate(Faker::getInstance()->date('Y-m-d'))->getImportDate()->shouldBeString();
    }

    public function it_should_be_string_report_start_date()
    {
        $this->setReportStartDate(Faker::getInstance()->date('Y-m-d'))->getReportStartDate()->shouldBeString();
    }

    public function it_should_be_string_report_end_date()
    {
        $this->setReportEndDate(Faker::getInstance()->date('Y-m-d'))->getReportEndDate()->shouldBeString();
    }

    public function it_should_fail_with_no_date()
    {
        $this->setRequestParameters();
        $this->setStartDate(null);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_multiple_date_types()
    {
        $this->setRequestParameters();
        $this->setImportDate(Faker::getInstance()
            ->dateTimeBetween('-2 years', 'now')->format('Y-m-d')
        );
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_start_date_with_missing_end_date()
    {
        $this->setRequestParameters();
        $this->setEndDate(null);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }
    public function it_should_fail_when_report_start_date_with_missing_report_end_date()
    {
        $this->setReportStartDate(Faker::getInstance()
            ->dateTimeBetween('-2 years', 'now')->format('Y-m-d')
        );
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_contain_per_page_parameter()
    {
        $this->setRequestParameters();
        $perPage = Faker::getInstance()->randomNumber(2);
        $this->setPerPage($perPage);

        $this->getDocument()->shouldContain("<per_page>{$perPage}</per_page>");
    }

    public function it_should_contain_page_parameter()
    {
        $this->setRequestParameters();
        $page = Faker::getInstance()->randomDigitNotNull();
        $this->setPage($page);

        $this->getDocument()->shouldContain("<page>{$page}</page>");
    }


    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setStartDate($faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'));
        $this->setEndDate($faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'));
    }
}
