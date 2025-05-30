<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial;

use Genesis\Api\Constants\NonFinancial\Kyc\VerificationDocumentTypes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Country;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\KycVerificationsCommonStub;
use spec\SharedExamples\Faker;

class KycVerificationsCommonSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(KycVerificationsCommonStub::class);
    }

    public function it_should_set_country_correctly()
    {
        $allowed = Country::getList();

        foreach ($allowed as $country) {
            $this->shouldNotThrow()->during(
                'setCountry',
                [$country]
            );
        }
    }

    public function it_should_fail_with_invalid_country()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setCountry',
            ['invalid_country']
        );
    }

    public function it_should_set_expiry_date_correctly()
    {
        $this->shouldNotThrow()->during(
            'setExpiryDate',
            [Faker::getInstance()->date('Y-m-d')]
        );

        $this->shouldNotThrow()->during(
            'setExpiryDate',
            ['']
        );
    }

    public function it_should_set_backside_proof_required_correctly()
    {
        $this->shouldNotThrow()->during(
            'setBacksideProofRequired',
            [Faker::getInstance()->boolean()]
        );

        $this->shouldNotThrow()->during(
            'setBacksideProofRequired',
            [1]
        );
    }

    public function it_should_set_document_supported_types_correctly()
    {
        $allowed = VerificationDocumentTypes::getAll();

        foreach ($allowed as $type) {
            $this->shouldNotThrow()->during(
                'setDocumentSupportedTypes',
                [[$type]]
            );
        }
    }

    public function it_should_fail_with_invalid_document_supported_types()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setDocumentSupportedTypes',
            [['INVALID_VALUE']]
        );
    }
}
