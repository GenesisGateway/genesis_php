<?php

namespace spec\SharedExamples\Genesis\Api\Request\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\VerificationDocumentTypes;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Country;

/**
 * Trait KycVerificationsExamples
 * @package spec\SharedExamples\Genesis\Api\Request\NonFinancial\Kyc
 */
trait KycVerificationsExamples
{
    public function it_should_contain_document_supported_types_when_set()
    {
        $this->setRequestParameters();
        $this->setDocumentSupportedTypes(
            $this->getFaker()->randomElements(VerificationDocumentTypes::getAll(), 2)
        );
        $this->getDocument()->shouldContain('supported_types');
    }

    public function it_should_contain_country_when_set()
    {
        $this->setRequestParameters();
        $this->setCountry(
            $this->getFaker()->randomElement(Country::getList())
        );
        $this->getDocument()->shouldContain('country');
    }

    public function it_should_contain_reference_id_when_set()
    {
        $this->setRequestParameters();
        $this->setReferenceId('reference-id');
        $this->getDocument()->shouldContain('reference_id');
    }

    public function it_should_contain_backside_proof_required_when_set()
    {
        $this->setRequestParameters();
        $this->setBacksideProofRequired(1);
        $this->getDocument()->shouldContain('backside_proof_required');
    }

    public function it_should_contain_expiry_date_when_set()
    {
        $this->setRequestParameters();
        $this->setExpiryDate($this->getFaker()->date());
        $this->getDocument()->shouldContain('expiry_date');
    }

    public function it_should_fail_with_invalid_document_supported_type()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setDocumentSupportedTypes', ['invalid_value']);
    }

    public function it_should_fail_with_invalid_country()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setCountry', ['invalid_value']);
    }

    public function it_should_fail_when_reference_id_too_short()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setReferenceId', [$this->getFaker()->randomNumber(3)]);
    }

    public function it_should_fail_when_reference_id_too_long()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setReferenceId', [str_repeat('X', 260)]);
    }
}
