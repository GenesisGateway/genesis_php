<?php

namespace spec\Genesis\Api\Request\NonFinancial\Kyc\Address;

use Genesis\Api\Constants\NonFinancial\Kyc\VerificationDocumentTypes;
use Genesis\Api\Request\NonFinancial\Kyc\Address\ByDocumentProof;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class ByDocumentProofSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(ByDocumentProof::class);
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->testMissingRequiredParameters([
            'reference_id',
            'document_full_address',
            'document_proof'
        ]);
    }

    public function it_should_fail_when_missing_document_supported_types()
    {
        $this->setRequestParameters();
        $this->setDocumentSupportedTypes([]);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_have_correct_endpoint()
    {
        $this->getApiConfig('url')
            ->shouldBe('https://staging.kyc.emerchantpay.net:443/api/v1/verifications/address/by_proof');
    }

    public function it_should_contain_with_enhanced_address_verification_when_set()
    {
        $this->setRequestParameters();
        $this->setWithEnhancedAddressVerification(true);
        $this->getDocument()->shouldContain('with_enhanced_address_verification');
    }

    protected function setRequestParameters()
    {
        $this->setReferenceId($this->getFaker()->uuid());
        $this->setDocumentSupportedTypes(
            $this->getFaker()->randomElements(VerificationDocumentTypes::getAll(), 2)
        );
        $this->setBacksideProofRequired($this->getFaker()->boolean());
        $this->setWithEnhancedAddressVerification($this->getFaker()->boolean());
        $this->setDocumentFirstName($this->getFaker()->firstName());
        $this->setDocumentMiddleName($this->getFaker()->lastName());
        $this->setDocumentLastName($this->getFaker()->lastName());
        $this->setDocumentFullAddress($this->getFaker()->address());
        $this->setDocumentProof($this->getFaker()->text(100));
    }
}
