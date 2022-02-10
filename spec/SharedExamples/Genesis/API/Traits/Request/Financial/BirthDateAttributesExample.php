<?php

namespace spec\SharedExamples\Genesis\API\Traits\Request\Financial;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\Exceptions\InvalidArgument;
use spec\SharedExamples\Faker;

/**
 * Trait BirthDateAttributesExample
 * @package spec\SharedExamples\Genesis\API\Traits\Request\Financial
 */
trait BirthDateAttributesExample
{
    public function it_should_set_birth_date_correctly()
    {
        $dateFormat = Faker::getInstance()->randomElement(DateTimeFormat::getDateFormats());
        $date = Faker::getInstance()->date($dateFormat);

        $this->shouldNotThrow()->during('setBirthDate', [$date]);

        $this->getBirthDate()->shouldBe(
            \DateTime::createFromFormat($dateFormat, $date)->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS)
        );
    }

    public function it_should_fail_when_birth_date_is_invalid()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBirthDate',
            [Faker::getInstance()->date('Ymd')]
        );
    }

    public function it_should_return_string_for_birth_date_value()
    {
        $dateFormat = Faker::getInstance()->randomElement(DateTimeFormat::getDateFormats());
        $date = Faker::getInstance()->date($dateFormat);

        $this->setBirthDate($date)->getBirthDate()->shouldBeString();
    }

    public function it_should_not_fail_when_unset_birth_date()
    {
        $this->shouldNotThrow()->during('setBirthDate', [null]);
    }
}
