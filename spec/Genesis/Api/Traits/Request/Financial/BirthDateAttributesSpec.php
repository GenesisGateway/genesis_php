<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use Genesis\Api\Constants\DateTimeFormat;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\BirthDateAttributesStub;
use spec\SharedExamples\Faker;

class BirthDateAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(BirthDateAttributesStub::class);
    }

    public function it_should_set_birth_date()
    {
        $dateFormat = Faker::getInstance()->randomElement(DateTimeFormat::getAll());
        $dateString = Faker::getInstance()->date($dateFormat);

        $this->shouldNotThrow()->during(
            'setBirthDate',
            [
                \DateTime::createFromFormat($dateFormat, $dateString)->format(
                    DateTimeFormat::DD_MM_YYYY_L_HYPHENS
                )
            ]
        );
    }

    public function it_should_unset_birth_date()
    {
        $this->setBirthDate(null)->shouldReturn($this);
        $this->getBirthDate()->shouldBeNull();
    }
}
