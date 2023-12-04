<?php

namespace spec\SharedExamples\Genesis\API\Request\Financial;

use Genesis\API\Constants\Transaction\Parameters\Funding\IdentifierTypes;
use Genesis\API\Constants\Transaction\Parameters\Funding\ReceiverAccountTypes;
use Genesis\Exceptions\ErrorParameter;
use spec\SharedExamples\Faker;

/**
 * Trait FundingAttributesExamples
 * @package spec\SharedExamples\Genesis\API\Request\Financial
 */
trait FundingAttributesExamples
{
    public function it_should_contain_funding_identifier_type_when_set()
    {
        $this->setRequestParameters();

        $this->setFundingIdentifierType(Faker::getInstance()->randomElement(IdentifierTypes::getAll()));
        $this->getDocument()->shouldContain('identifier_type');
    }

    public function it_should_contain_funding_receiver_names_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $this->setFundingReceiverFirstName($faker->firstName());
        $this->getDocument()->shouldContain('first_name');

        $this->setFundingReceiverLastName($faker->lastName());
        $this->getDocument()->shouldContain('last_name');
    }

    public function it_should_contain_funding_receiver_country_when_set()
    {
        $this->setRequestParameters();

        $this->setFundingReceiverCountry('AF');
        $this->getDocument()->shouldContain(
            "<country>{$this->getWrappedObject()->getFundingReceiverCountry()}</country>"
        );
    }

    public function it_should_contain_funding_receiver_account_number_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $this->setFundingReceiverAccountNumber($faker->randomNumber(4));
        $this->getDocument()->shouldContain('account_number');
    }

    public function it_should_contain_funding_receiver_account_number_type_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $this->setFundingReceiverAccountNumberType($faker->randomElement(ReceiverAccountTypes::getAll()));
        $this->getDocument()->shouldContain('account_number_type');
    }
}
