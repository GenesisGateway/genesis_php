<?php

namespace spec\SharedExamples\Genesis\API\Request\Financial\Cards;

use Genesis\API\Constants\Transaction\Parameters\CustomerIdentification\CustomerIdentificationOwner;
use Genesis\API\Constants\Transaction\Parameters\CustomerIdentification\CustomerIdentificationSubType;
use Genesis\API\Constants\Transaction\Parameters\CustomerIdentification\CustomerIdentificationType;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Country;

trait CustomerIdentificationExamples
{
    public function it_can_build_customer_identification_structure()
    {
        $randomIDNumber = $this->getFaker()->numberBetween(1, PHP_INT_MAX);
        $documentOwner  = $this->getFaker()->randomElement(CustomerIdentificationOwner::getAll());
        $idType         = $this->getFaker()->randomElement(CustomerIdentificationType::getAll());
        $idSubType      = $this->getFaker()->randomElement(CustomerIdentificationSubType::getAll());
        $idCountry      = $this->getFaker()->randomElement(Country::getList());

        $this->setRequestParameters();
        $this->setCustomerIdentificationDocumentId($randomIDNumber);
        $this->setCustomerIdentificationOwner($documentOwner);
        $this->setCustomerIdentificationType($idType);
        $this->setCustomerIdentificationSubtype($idSubType);
        $this->setCustomerIdentificationIssuingCountry($idCountry);
        $this->getDocument()->shouldContain("\n\x20\x20<customer_identification>" .
                                            "\n\x20\x20\x20\x20<owner>$documentOwner</owner>" .
                                            "\n\x20\x20\x20\x20<type>$idType</type>" .
                                            "\n\x20\x20\x20\x20<subtype>$idSubType</subtype>" .
                                            "\n\x20\x20\x20\x20<document_id>$randomIDNumber</document_id>" .
                                            "\n\x20\x20\x20\x20<issuing_country>$idCountry</issuing_country>" .
                                            "\n\x20\x20</customer_identification>");
    }

    public function it_should_fail_on_wrong_document_subtype()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setCustomerIdentificationSubtype',
            [$this->getFaker()->word()]
        );
    }

    public function it_should_fail_on_wrong_document_type()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setCustomerIdentificationType',
            [$this->getFaker()->word()]
        );
    }

    public function it_should_fail_on_wrong_country_code()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setCustomerIdentificationIssuingCountry',
            [$this->getFaker()->word()]
        );
    }

    public function it_should_fail_on_wrong_document_owner()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setCustomerIdentificationOwner',
            [$this->getFaker()->numberBetween(1, 100)]
        );
    }
}
