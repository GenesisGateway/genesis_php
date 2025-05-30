<?php

namespace spec\Genesis\Api\Request\NonFinancial\Kyc\ClientVerification;

use Genesis\Api\Constants\NonFinancial\Kyc\VerificationAddressesTypes;
use Genesis\Api\Constants\NonFinancial\Kyc\VerificationDocumentTypes;
use Genesis\Api\Constants\NonFinancial\Kyc\VerificationLanguages;
use Genesis\Api\Request\NonFinancial\Kyc\ClientVerification\RemoteIdentity;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\Kyc\KycVerificationsExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class RemoteIdentitySpec extends ObjectBehavior
{
    use KycVerificationsExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(RemoteIdentity::class);
    }

    public function it_should_have_correct_consumer_verification_endpoint()
    {
        $this->getApiConfig('url')
            ->shouldContain('https://staging.kyc.emerchantpay.net:443/api/v1/verifications');
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setEmail(null);
        $this->setReferenceId(null);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_contain_document_proof_when_set()
    {
        $this->setRequestParameters();
        $this->setDocumentProof($this->getFaker()->word());
        $this->getDocument()->shouldContain('proof');
    }

    public function it_should_contain_document_first_name_when_set()
    {
        $this->setRequestParameters();
        $this->setDocumentFirstName($this->getFaker()->firstName());
        $this->getDocument()->shouldContain('first_name');
    }

    public function it_should_contain_document_middle_name_when_set()
    {
        $this->setRequestParameters();
        $this->setDocumentMiddleName($this->getFaker()->firstName());
        $this->getDocument()->shouldContain('middle_name');
    }

    public function it_should_contain_document_last_name_when_set()
    {
        $this->setRequestParameters();
        $this->setDocumentLastName($this->getFaker()->lastName());
        $this->getDocument()->shouldContain('last_name');
    }

    public function it_should_contain_full_address_when_set()
    {
        $this->setRequestParameters();
        $this->setDocumentFullAddress($this->getFaker()->address());
        $this->getDocument()->shouldContain('full_address');
    }

    public function it_should_contain_date_of_birth_when_set()
    {
        $this->setRequestParameters();
        $this->setDocumentDateOfBirth($this->getFaker()->date());
        $this->getDocument()->shouldContain('date_of_birth');
    }

    protected function setRequestParameters()
    {
        $this->setEmail($this->getFaker()->email());
        $this->setReferenceId('transaction-reference-id');
    }
}
