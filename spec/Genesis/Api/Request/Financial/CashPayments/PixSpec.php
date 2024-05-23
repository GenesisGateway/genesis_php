<?php

namespace spec\Genesis\Api\Request\Financial\CashPayments;

use Genesis\Api\Constants\Transaction\Parameters\CashPayments\CompanyTypes;
use Genesis\Api\Constants\Transaction\Parameters\CashPayments\Gender;
use Genesis\Api\Constants\Transaction\Parameters\CashPayments\MaritalStatuses;
use Genesis\Api\Request\Financial\CashPayments\Pix;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class PixSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'amount',
            'currency',
            'document_id'
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Pix::class);
    }

    public function it_should_fail_when_country_is_invalid()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('BG');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_with_wrong_document_id()
    {
        $this->setDocumentId('123ABC');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_set_parameters()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();

        $this->setBirthDate($faker->date());
        $this->setBirthCity($faker->city());
        $this->setBirthState($faker->state());
        $this->setGender($faker->randomElement(Gender::getAll()));
        $this->setMaritalStatus($faker->randomElement(MaritalStatuses::getAll()));
        $this->setSenderOccupation('occupation');
        $this->setNationality('nationality');
        $this->setCountryOfOrigin($faker->country());
        $this->setCompanyType($faker->randomElement(CompanyTypes::getAll()));
        $this->setCompanyActivity('activity');
        $this->setIncorporationDate($faker->date());
        $this->setMothersName($faker->firstName('female'));
        $this->setReturnPendingUrl($faker->url());

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_with_invalid_gender()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setGender', [11111]);
    }

    public function it_should_fail_with_invalid_company_type()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setCompanyType', [11111]);
    }

    public function it_should_fail_with_invalid_marital_status()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setMaritalStatus', [11111]);
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setDocumentId('12345678901');
        $this->setCurrency('BRL');
        $this->setBillingCountry('BR');
    }
}
