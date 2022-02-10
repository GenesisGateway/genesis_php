<?php

namespace spec\Genesis\API\Traits\Request\NonFinancial;

use Genesis\API\Request\Base\NonFinancial\KYC\BaseRequest;
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
        $allowed = [
            BaseRequest::DOCUMENT_TYPE_SSN,
            BaseRequest::DOCUMENT_TYPE_PASSPORT_REGISTRY,
            BaseRequest::DOCUMENT_TYPE_PERSONAL_ID,
            BaseRequest::DOCUMENT_TYPE_IDENTITY_CARD,
            BaseRequest::DOCUMENT_TYPE_DRIVER_LICENSE,
            BaseRequest::DOCUMENT_TYPE_TRAVEL_DOCUMENT,
            BaseRequest::DOCUMENT_TYPE_RESIDENCE_PERMIT,
            BaseRequest::DOCUMENT_TYPE_IDENTITY_CERTIFICATE,
            BaseRequest::DOCUMENT_TYPE_FEDERAL_REGISTER,
            BaseRequest::DOCUMENT_TYPE_ELECTRON_CREDENTIALS,
            BaseRequest::DOCUMENT_TYPE_CPF
        ];

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
        $allowed = [
            BaseRequest::GENDER_MALE,
            BaseRequest::GENDER_FEMALE
        ];

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
