<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\Funding\BusinessApplicationIdentifierTypes;
use Genesis\Api\Constants\Transaction\Parameters\Funding\IdentifierTypes;
use Genesis\Api\Constants\Transaction\Parameters\Funding\PersonTypes;
use Genesis\Api\Constants\Transaction\Parameters\Funding\ReceiverAccountTypes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Country;
use spec\SharedExamples\Faker;

/**
 * Trait FundingAttributesExamples
 * @package spec\SharedExamples\Genesis\Api\Request\Financial
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

    public function it_should_contain_funding_business_application_identifier()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();
        $businessApplicationIdentifier = $faker->randomElement(BusinessApplicationIdentifierTypes::getAll());
        $this->setFundingBusinessApplicationIdentifier($businessApplicationIdentifier);
        $this->getDocument()->shouldMatch(
            "/<funding>\s*<business_application_identifier>{$businessApplicationIdentifier}<\/business_application_identifier>\s*<\/funding>/"
        );
    }

    public function it_should_not_throw_when_set_funding_business_application_identifier()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();
        $this->shouldNotThrow(InvalidArgument::class)
            ->during(
                'setFundingBusinessApplicationIdentifier',
                [
                    $faker->randomElement(BusinessApplicationIdentifierTypes::getAll())
                ]
            );
    }

    public function it_should_throw_when_funding_business_application_identifier_invalid()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setFundingBusinessApplicationIdentifier', ['invalid']);
    }

    public function it_should_contain_funding_sender_name_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $name = $faker->name();
        $this->setFundingSenderName($name);
        $this->getDocument()->shouldMatch("/<sender>\s*<name>{$name}<\/name>\s*<\/sender>/");
    }

    public function it_should_contain_funding_sender_reference_number_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $refNumber = $faker->randomNumber(5);
        $this->setFundingSenderReferenceNumber($refNumber);
        $this->getDocument()->shouldMatch(
            "/<sender>\s*<reference_number>{$refNumber}<\/reference_number>\s*<\/sender>/"
        );
    }

    public function it_should_contain_funding_sender_country_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $country = $faker->randomElement(Country::getList());
        $this->setFundingSenderCountry($country);
        $this->getDocument()->shouldMatch(
            "/<sender>\s*<country>$country<\/country>\s*<\/sender>/"
        );
    }

    public function it_should_contain_funding_sender_address_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $address = $faker->address();
        $this->setFundingSenderAddress($address);
        $this->getDocument()->shouldMatch(
            "/<sender>\s*<address>{$this->escapeParams($address)}<\/address>\s*<\/sender>/"
        );
    }

    public function it_should_contain_funding_sender_state_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $state = $faker->state();
        $this->setFundingSenderState($state);
        $this->getDocument()->shouldMatch(
            "/<sender>\s*<state>{$state}<\/state>\s*<\/sender>/"
        );
    }

    public function it_should_contain_funding_sender_city_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $city = $faker->city();
        $this->setFundingSenderCity($city);
        $this->getDocument()->shouldMatch(
            "/<sender>\s*<city>{$this->escapeParams($city)}<\/city>\s*<\/sender>/"
        );
    }

    public function it_should_contain_funding_receiver_address_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $address = $faker->address();
        $this->setFundingReceiverAddress($address);
        $this->getDocument()->shouldMatch(
            "/<receiver>\s*<address>{$this->escapeParams($address)}<\/address>\s*<\/receiver>/"
        );
    }

    public function it_should_contain_funding_receiver_state_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $state = $faker->state();
        $this->setFundingReceiverState($state);
        $this->getDocument()->shouldMatch(
            "/<receiver>\s*<state>{$state}<\/state>\s*<\/receiver>/"
        );
    }

    public function it_should_contain_funding_receiver_city_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $city = $faker->city();
        $this->setFundingReceiverCity($city);
        $this->getDocument()->shouldMatch(
            "/<receiver>\s*<city>{$this->escapeParams($city)}<\/city>\s*<\/receiver>/"
        );
    }

    public function it_should_contain_funding_receiver_type_when_set()
    {
        $this->setRequestParameters();

        $this->setFundingReceiverType(PersonTypes::LEGAL);
        $this->getDocument()->shouldMatch(
            "/<receiver>\s*<type>" . PersonTypes::LEGAL . "<\/type>\s*<\/receiver>/"
        );
    }

    public function it_should_contain_funding_receiver_address2_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $address2 = $faker->address();
        $this->setFundingReceiverAddress2($address2);
        $this->getDocument()->shouldMatch(
            "/<receiver>.*<address2>{$this->escapeParams($address2)}<\/address2>.*<\/receiver>/s"
        );
    }

    public function it_should_contain_funding_receiver_street_name_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $streetName = $faker->streetName();
        $this->setFundingReceiverStreetName($streetName);
        $this->getDocument()->shouldMatch(
            "/<receiver>.*<street_name>{$this->escapeParams($streetName)}<\/street_name>.*<\/receiver>/s"
        );
    }

    public function it_should_contain_funding_receiver_zip_code_when_set()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $zipCode = $faker->postcode();
        $this->setFundingReceiverZipCode($zipCode);
        $this->getDocument()->shouldMatch(
            "/<receiver>.*<zip_code>{$this->escapeParams($zipCode)}<\/zip_code>.*<\/receiver>/s"
        );
    }

    public function it_should_contain_funding_sender_type_when_set()
    {
        $this->setRequestParameters();

        $this->setFundingSenderType(PersonTypes::LEGAL);
        $this->getDocument()->shouldMatch(
            "/<sender>\s*<type>" . PersonTypes::LEGAL . "<\/type>\s*<\/sender>/"
        );
    }

    public function it_should_not_contain_funding_node_when_no_funding_data_set()
    {
        $this->setRequestParameters();

        $this->getDocument()->shouldNotContain('<funding>');
    }

    public function it_should_build_with_only_pre_existing_funding_fields()
    {
        $faker = Faker::getInstance();

        $this->setRequestParameters();

        $this->setFundingIdentifierType($faker->randomElement(IdentifierTypes::getAll()));
        $this->setFundingReceiverFirstName($faker->firstName());
        $this->setFundingReceiverLastName($faker->lastName());

        $this->getDocument()->shouldContain('<funding>');
        $this->getDocument()->shouldNotMatch(
            "/<receiver>.*<type>.*<\/type>.*<\/receiver>/s"
        );
        $this->getDocument()->shouldNotMatch(
            "/<sender>\s*<type>.*<\/type>/s"
        );
    }

    private function escapeParams($param)
    {
        return addcslashes(preg_replace('/&/', '&amp;', $param), "()'");
    }
}
