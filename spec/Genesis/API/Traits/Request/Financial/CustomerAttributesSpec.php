<?php

namespace spec\Genesis\API\Traits\Request\Financial;

use Genesis\API\Constants\DateTimeFormat;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\OnlineBankingPayments\CustomerAttributesStub;
use spec\SharedExamples\Faker;

class CustomerAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(CustomerAttributesStub::class);
    }

    public function it_should_set_company_type_correctly()
    {
        $this->shouldNotThrow()->during('setCompanyType', ['company_type']);
    }

    public function it_should_set_company_activity_correctly()
    {
        $this->shouldNotThrow()->during('setCompanyActivity', ['company_activity']);
    }

    public function it_should_set_mothers_name_correctly()
    {
        $faker = Faker::getInstance();
        $this->shouldNotThrow()->during('setMothersName', ["{$faker->firstNameFemale()} {$faker->lastName()}"]);
    }

    public function it_should_set_incorporation_date()
    {
        $dateFormat = Faker::getInstance()->randomElement(DateTimeFormat::getAll());
        $dateString = Faker::getInstance()->date($dateFormat);

        $this->shouldNotThrow()->during(
            'setIncorporationDate',
            [
                \DateTime::createFromFormat($dateFormat, $dateString)->format(
                    DateTimeFormat::YYYY_MM_DD_ISO_8601
                )
            ]
        );
    }

    public function it_should_unset_incorporation_date()
    {
        $this->setIncorporationDate(null)->shouldReturn($this);
        $this->getIncorporationDate()->shouldBeNull();
    }
}
