<?php

namespace spec\Genesis\Api\Request\NonFinancial\Kyc\ClientVerification;

use Genesis\Api\Constants\NonFinancial\Kyc\VerificationAddressesTypes;
use Genesis\Api\Constants\NonFinancial\Kyc\VerificationDocumentTypes;
use Genesis\Api\Constants\NonFinancial\Kyc\VerificationLanguages;
use Genesis\Api\Request\NonFinancial\Kyc\ClientVerification\Verify;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\NonFinancial\Kyc\KycVerificationsExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class VerifySpec extends ObjectBehavior
{
    use KycVerificationsExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Verify::class);
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->testMissingRequiredParameters([
            'email'
        ]);
    }

    public function it_should_have_correct_consumer_verification_endpoint()
    {
        $this->getApiConfig('url')
             ->shouldContain('https://staging.kyc.emerchantpay.net:443/api/v1/verifications');
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

    public function it_should_include_business_when_set()
    {
        $date = $this->getFaker()->date('Y-m-d');
        $name = $this->getFaker()->company();

        $this->setRequestParameters();
        $this->setBackgroundChecksVerificationsBusinessIncorporationDate($date);
        $this->setBackgroundChecksVerificationsBusinessName($name);
        $this->getDocument()->shouldContain('{"business":{"name":"' . $name . '","incorporation_date":"' . $date . '"}}');
    }

    public function it_should_throw_when_name_not_set()
    {
        $date = $this->getFaker()->date('Y-m-d');

        $this->setRequestParameters();
        $this->setBackgroundChecksVerificationsBusinessIncorporationDate($date);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_contain_show_consent_when_set()
    {
        $value = $this->getFaker()->boolean();

        $this->setRequestParameters();
        $this->setShowConsent($value);
        $this->getDocument()->shouldContain('"show_consent":' . json_encode($value));
    }

    public function it_should_contain_show_privacy_policy_when_set()
    {
        $value = $this->getFaker()->boolean();

        $this->setRequestParameters();
        $this->setShowPrivacyPolicy($value);
        $this->getDocument()->shouldContain('"show_privacy_policy":' . json_encode($value));
    }

    public function it_should_contain_with_alias_search_when_set()
    {
        $value = $this->getFaker()->boolean();

        $this->setRequestParameters();
        $this->setBackgroundChecksWithAliasSearch($value);
        $this->getDocument()->shouldContain('"background_checks":{"with_alias_search":' . json_encode($value) . '}');
    }

    public function it_should_contain_with_associates_search_when_set()
    {
        $value = $this->getFaker()->boolean();

        $this->setRequestParameters();
        $this->setBackgroundChecksWithAssociatesSearch($value);
        $this->getDocument()->shouldContain('"background_checks":{"with_associates_search":' . json_encode($value) . '}');
    }

    public function it_should_contain_with_enhanced_data_when_set()
    {
        $value = $this->getFaker()->boolean();

        $this->setRequestParameters();
        $this->setDocumentWithEnhancedData($value);
        $this->getDocument()->shouldContain('"document":{"with_enhanced_data":' . json_encode($value) . '}');
    }

    public function it_should_contain_allow_fuzzy_match_when_set()
    {
        $value = $this->getFaker()->boolean();

        $this->setRequestParameters();
        $this->setDocumentAllowFuzzyMatch($value);
        $this->getDocument()->shouldContain('"document":{"allow_fuzzy_match":' . json_encode($value) . '}');
    }

    public function it_should_contain_allow_decline_during_single_step_when_set()
    {
        $value = $this->getFaker()->boolean();

        $this->setRequestParameters();
        $this->setDocumentAllowDeclineDuringSingleStep($value);
        $this->getDocument()->shouldContain('"document":{"allow_decline_during_single_step":' . json_encode($value) . '}');
    }

    public function it_should_contain_with_ocr_form_when_set()
    {
        $value = $this->getFaker()->boolean();

        $this->setRequestParameters();
        $this->setDocumentWithOpticalCharacterRecognitionForm($value);
        $this->getDocument()->shouldContain('"document":{"with_optical_character_recognition_form":' . json_encode($value) . '}');
    }

    public function it_should_contain_allow_paper_based_when_set()
    {
        $value = $this->getFaker()->boolean();

        $this->setRequestParameters();
        $this->setVerificationInstructionsAllowPaperBased($value);
        $this->getDocument()->shouldContain('"verification_instructions":{"allow_paper_based":' . json_encode($value) . '}');
    }

    public function it_should_contain_allow_photocopy_when_set()
    {
        $value = $this->getFaker()->boolean();

        $this->setRequestParameters();
        $this->setVerificationInstructionsAllowPhotocopy($value);
        $this->getDocument()->shouldContain('"verification_instructions":{"allow_photocopy":' . json_encode($value) . '}');
    }

    public function it_should_contain_allow_laminated_when_set()
    {
        $value = $this->getFaker()->boolean();

        $this->setRequestParameters();
        $this->setVerificationInstructionsAllowLaminated($value);
        $this->getDocument()->shouldContain('"verification_instructions":{"allow_laminated":' . json_encode($value) . '}');
    }

    public function it_should_contain_allow_screenshot_when_set()
    {
        $value = $this->getFaker()->boolean();

        $this->setRequestParameters();
        $this->setVerificationInstructionsAllowScreenshot($value);
        $this->getDocument()->shouldContain('"verification_instructions":{"allow_screenshot":' . json_encode($value) . '}');
    }

    public function it_should_contain_allow_cropped_when_set()
    {
        $value = $this->getFaker()->boolean();

        $this->setRequestParameters();
        $this->setVerificationInstructionsAllowCropped($value);
        $this->getDocument()->shouldContain('"verification_instructions":{"allow_cropped":' . json_encode($value) . '}');
    }

    public function it_should_contain_allow_scanned_when_set()
    {
        $value = $this->getFaker()->boolean();

        $this->setRequestParameters();
        $this->setVerificationInstructionsAllowScanned($value);
        $this->getDocument()->shouldContain('"verification_instructions":{"allow_scanned":' . json_encode($value) . '}');
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
