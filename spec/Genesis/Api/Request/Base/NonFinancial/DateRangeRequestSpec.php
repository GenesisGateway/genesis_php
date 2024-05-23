<?php

namespace spec\Genesis\Api\Request\Base\NonFinancial;

use Genesis\Api\Request\Base\NonFinancial\DateRangeRequest;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Base\Request\NonFinancial\DateRangeRequestStub;
use spec\SharedExamples\Faker;

class DateRangeRequestSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(DateRangeRequestStub::class);
    }

    public function it_should_fail_when_set_start_date_with_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setStartDate',
            [
                Faker::getInstance()->dateTimeThisYear()->format('Ymd')
            ]
        );
    }

    public function it_should_be_string_start_date()
    {
        $this->setStartDate(Faker::getInstance()->dateTimeThisYear()->format('Y-m-d'));
        $this->getStartDate()->shouldBeString();
    }

    public function it_should_be_null_when_unset_start_date()
    {
        $this->setStartDate(null);
        $this->getStartDate()->shouldBeNull();
    }

    public function it_should_return_proper_value_for_start_date()
    {
        $date = Faker::getInstance()->dateTimeThisYear()->format('Y-m-d');

        $this->setStartDate($date);
        $this->getStartDate()->shouldBe($date);
    }

    public function it_should_return_proper_class_instance_for_set_start_date()
    {
        $this->setStartDate(null)->shouldBeAnInstanceOf(DateRangeRequest::class);
        $this->setStartDate(
            Faker::getInstance()->dateTimeThisYear()->format('Y-m-d')
        )->shouldBeAnInstanceOf(DateRangeRequest::class);
    }

    public function it_should_not_fail_with_correct_date_set_start_date()
    {
        $this->shouldNotThrow()->during('setStartDate',
            [
                Faker::getInstance()->date('d.m.Y')
            ]
        );
    }

    public function it_should_fail_when_set_end_date_with_invalid_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setEndDate',
            [
                Faker::getInstance()->dateTimeThisYear()->format('Ymd')
            ]
        );
    }

    public function it_should_be_string_end_date()
    {
        $this->setEndDate(Faker::getInstance()->dateTimeThisYear()->format('Y-m-d'));
        $this->getEndDate()->shouldBeString();
    }

    public function it_should_return_proper_value_for_end_date()
    {
        $date = Faker::getInstance()->dateTimeThisYear()->format('Y-m-d');

        $this->setEndDate($date);
        $this->getEndDate()->shouldBe($date);
    }

    public function it_should_be_null_when_unset_end_date()
    {
        $this->setEndDate(null);
        $this->getEndDate()->shouldBeNull();
    }

    public function it_should_return_proper_class_instance_after_set_end_date()
    {
        $this->setEndDate(null)->shouldBeAnInstanceOf(DateRangeRequest::class);
        $this->setEndDate(
            Faker::getInstance()->dateTimeThisYear()->format('Y-m-d')
        )->shouldBeAnInstanceOf(DateRangeRequest::class);
    }
    public function it_should_not_fail_with_correct_date_set_end_date()
    {
        $this->shouldNotThrow()->during('setEndDate',
            [
                Faker::getInstance()->date('d.m.Y')
            ]
        );
    }

    public function it_should_be_int_get_page_parameter()
    {
        $this->setPage(Faker::getInstance()->numberBetween(0, PHP_INT_MAX));
        $this->getPage()->shouldBeInt();

        $this->setPage(null);
        $this->getPage()->shouldBeInt();
    }

    public function it_should_return_proper_class_instance_for_set_page()
    {
        $this->setPage(null)->shouldBeAnInstanceOf(DateRangeRequest::class);
        $this->setPage(
            Faker::getInstance()->numberBetween(1, PHP_INT_MAX)
        )->shouldBeAnInstanceOf(DateRangeRequest::class);
    }

    public function it_should_return_proper_value_for_set_page()
    {
        $page = Faker::getInstance()->numberBetween(0, PHP_INT_MAX);

        $this->setPage($page);
        $this->getPage()->shouldBe($page);
    }

    public function it_should_be_int_get_per_page_parameter()
    {
        $this->setPerPage(Faker::getInstance()->numberBetween(0, PHP_INT_MAX));
        $this->getPerPage()->shouldBeInt();

        $this->setPerPage(null);
        $this->getPerPage()->shouldBeInt();
    }

    public function it_should_return_proper_class_instance_for_set_per_page()
    {
        $this->setPerPage(null)->shouldBeAnInstanceOf(DateRangeRequest::class);
        $this->setPerPage(
            Faker::getInstance()->numberBetween(0, PHP_INT_MAX)
        )->shouldBeAnInstanceOf(DateRangeRequest::class);
    }

    public function it_should_return_proper_value_set_per_page()
    {
        $perPage = Faker::getInstance()->numberBetween(0, PHP_INT_MAX);

        $this->setPerPage($perPage);
        $this->getPerPage()->shouldBe($perPage);
    }
}
