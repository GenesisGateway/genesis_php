<?php

namespace spec\Genesis\Api\Request\NonFinancial\Kyc\ClientVerification;

use Genesis\Api\Constants\NonFinancial\Kyc\VerificationAddressesTypes;
use Genesis\Api\Constants\NonFinancial\Kyc\VerificationDocumentTypes;
use Genesis\Api\Constants\NonFinancial\Kyc\VerificationLanguages;
use Genesis\Api\Request\NonFinancial\Kyc\ClientVerification\Verify;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class VerifySpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Verify::class);
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->testMissingRequiredParameters([
            'email',
            'redirect_url'
        ]);
    }

    public function it_should_have_correct_consumer_verification_endpoint()
    {
        $this->getApiConfig('url')
             ->shouldContain('https://staging.kyc.emerchantpay.net:443/api/v1/verifications');
    }

    public function it_should_fail_when_wrong_document_type()
    {
        $this->shouldThrow(InvalidArgument::class)
             ->during('setDocumentSupportedTypes', [$this->getFaker()->uuid()]);
    }

    public function it_should_fail_when_wrong_verification_mode()
    {
        $this->shouldThrow(InvalidArgument::class)
             ->during('setVerificationMode', [$this->getFaker()->uuid()]);
    }

    public function it_should_fail_when_wrong_address_supported_types()
    {
        $this->shouldThrow(InvalidArgument::class)
             ->during('setAddressSupportedTypes', [$this->getFaker()->uuid()]);
    }

    public function it_should_fail_when_wrong_country()
    {
        $this->shouldThrow(InvalidArgument::class)
             ->during('setCountry', [$this->getFaker()->uuid()]);
    }

    public function it_should_return_correct_string_when_allow_online()
    {
        $this->setFaceAllowOnline('0');
        $this->getFaceAllowOnline()->shouldEqual(false);
    }

    public function it_should_return_correct_string_when_allow_offline()
    {
        $this->setFaceAllowOffline('0');
        $this->getFaceAllowOffline()->shouldNotEqual(true);
    }

    public function it_should_return_correct_string_when_check_duplicate_request()
    {
        $this->setFaceCheckDuplicateRequest('0');
        $this->getFaceCheckDuplicateRequest()->shouldNotEqual(true);
    }

    public function it_should_fail_without_document_types()
    {
        $this->setEmail($this->getFaker()->email());
        $this->setRedirectUrl('https://example.com');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_wrong_document_verification_type()
    {
        $this->shouldThrow(InvalidArgument::class)
             ->during('setDocumentSupportedTypes', ['wrong_value']);
    }

    public function it_should_not_fail_when_valid_document_verification_type()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_when_wrong_address_type()
    {
        $this->shouldThrow(InvalidArgument::class)
            ->during('setAddressSupportedTypes', ['wrong_value']);
    }

    public function it_should_not_fail_when_valid_address_type()
    {
        $this->setRequestParameters();
        $this->setAddressSupportedTypes(
            $this->getFaker()->randomElements(VerificationAddressesTypes::getAll(), 2)
        );

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_when_wrong_language_code()
    {
        $this->shouldThrow(InvalidArgument::class)
             ->during('setLanguage', [$this->getFaker()->uuid()]);
    }

    public function it_should_set_correct_language_code()
    {
        $this->setRequestParameters();
        $this->setLanguage($this->getFaker()->randomElement(VerificationLanguages::getAll()));
        $this->shouldNotThrow()->during('getDocument');
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

    protected function setRequestParameters()
    {
        $this->setEmail($this->getFaker()->email());
        $this->setRedirectUrl($this->getFaker()->url());
        $this->setDocumentSupportedTypes(
            $this->getFaker()->randomElements(VerificationDocumentTypes::getAll(), 2)
        );
    }
}
