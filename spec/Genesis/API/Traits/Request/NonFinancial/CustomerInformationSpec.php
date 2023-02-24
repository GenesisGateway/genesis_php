<?php

namespace spec\Genesis\API\Traits\Request\NonFinancial;

use Genesis\API\Constants\NonFinancial\KYC\DocumentTypes;
use Genesis\API\Constants\NonFinancial\KYC\Genders;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\NonFinancial\CustomerInformationStub;
use spec\SharedExamples\Genesis\API\Traits\Request\Financial\BirthDateAttributesExample;

class CustomerInformationSpec extends ObjectBehavior
{
    use BirthDateAttributesExample;

    public function let()
    {
        $this->beAnInstanceOf(CustomerInformationStub::class);
    }

    public function it_should_set_document_type_correctly()
    {
        $allowed = DocumentTypes::getAll();

        foreach ($allowed AS $type) {
            $this->shouldNotThrow()->during(
                'setDocumentType',
                [$type]
            );
        }
    }

    public function it_should_fail_when_document_type_is_invalid()
    {
        $this->shouldThrow()->during(
            'setDocumentType',
            [88]
        );
    }

    public function it_should_set_gender_correctly()
    {
        $allowed = Genders::getAll();

        foreach ($allowed AS $gender) {
            $this->shouldNotThrow()->during(
                'setGender',
                [$gender]
            );
        }
    }

    public function it_should_fail_when_gender_is_invalid()
    {
        $this->shouldThrow()->during(
            'setGender',
            ['FM']
        );
    }
}
