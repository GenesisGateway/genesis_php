<?php

namespace spec\Genesis\Api\Constants;

use PhpSpec\ObjectBehavior;

class ErrorsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Api\Constants\Errors');
    }

    public function it_can_resolve_error_codes()
    {
        $this::getErrorCode('REMOTE_ERROR')->shouldBe(900);
    }

    public function it_can_resolve_errors()
    {
        $this::getErrorDescription('420')->shouldBe('Wrong Workflow specified.');
    }

    public function it_should_return_correct_code()
    {
        $this::getErrorDescription(100)->shouldBe('A general system error occurred.');
    }

    public function it_should_return_correct_issuer_code()
    {
        $this::getIssuerResponseCode(04)->shouldBe('Pickup card (no fraud) / Capture card');
        $this::getIssuerResponseCode(05)->shouldBe('Do not honour');
    }

    public function it_should_have_rapid_dispute_resolution_not_found_constant()
    {
        $this::getErrorCode('RAPID_DISPUTE_RESOLUTION_NOT_FOUND_ERROR')->shouldBe(471);
    }

    public function it_should_have_bank_reject_constant()
    {
        $this::getErrorCode('BANK_REJECT_ERROR')->shouldBe(501);
    }

    public function it_should_have_sca_required_constant()
    {
        $this::getErrorCode('SCA_REQUIRED_ERROR')->shouldBe(551);
    }

    public function it_should_have_invalid_scheme_tokenization_merchant_configuration_constant()
    {
        $this::getErrorCode('INVALID_SCHEME_TOKENIZATION_MERCHANT_CONFIGURATION_ERROR')->shouldBe(731);
    }

    public function it_should_have_existing_scheme_token_constant()
    {
        $this::getErrorCode('EXISTING_SCHEME_TOKEN_ERROR')->shouldBe(732);
    }

    public function it_should_have_tokenize_forbidden_constant()
    {
        $this::getErrorCode('TOKENIZE_FORBIDDEN_ERROR')->shouldBe(741);
    }

    public function it_should_have_update_token_forbidden_constant()
    {
        $this::getErrorCode('UPDATE_TOKEN_FORBIDDEN_ERROR')->shouldBe(742);
    }

    public function it_should_have_validate_token_forbidden_constant()
    {
        $this::getErrorCode('VALIDATE_TOKEN_FORBIDDEN_ERROR')->shouldBe(743);
    }

    public function it_should_have_delete_token_forbidden_constant()
    {
        $this::getErrorCode('DELETE_TOKEN_FORBIDDEN_ERROR')->shouldBe(744);
    }

    public function it_should_have_client_side_encryption_constant()
    {
        $this::getErrorCode('CLIENT_SIDE_ENCRYPTION_ERROR')->shouldBe(750);
    }

    public function it_should_have_client_side_encryption_not_enabled_constant()
    {
        $this::getErrorCode('CLIENT_SIDE_ENCRYPTION_NOT_ENABLED_ERROR')->shouldBe(751);
    }

    public function it_should_describe_rapid_dispute_resolution_not_found_error()
    {
        $this::getErrorDescription(471)->shouldBe('Rapid Dispute Resolution not found!');
    }

    public function it_should_describe_bank_reject_error()
    {
        $this::getErrorDescription(501)->shouldBe('Transaction declined due to a rejection by the bank.');
    }

    public function it_should_describe_sca_required_error()
    {
        $this::getErrorDescription(551)->shouldBe('SCA required!');
    }

    public function it_should_describe_invalid_scheme_tokenization_merchant_configuration_error()
    {
        $this::getErrorDescription(731)->shouldBe('Invalid scheme tokenization merchant configuration!');
    }

    public function it_should_describe_existing_scheme_token_error()
    {
        $this::getErrorDescription(732)->shouldBe('Token already scheme tokenized!');
    }

    public function it_should_describe_tokenize_forbidden_error()
    {
        $this::getErrorDescription(741)->shouldBe('Tokenize action is forbidden!');
    }

    public function it_should_describe_update_token_forbidden_error()
    {
        $this::getErrorDescription(742)->shouldBe('Update token action is forbidden!');
    }

    public function it_should_describe_validate_token_forbidden_error()
    {
        $this::getErrorDescription(743)->shouldBe('Validate token action is forbidden!');
    }

    public function it_should_describe_delete_token_forbidden_error()
    {
        $this::getErrorDescription(744)->shouldBe('Delete token action is forbidden!');
    }

    public function it_should_describe_client_side_encryption_error()
    {
        $this::getErrorDescription(750)->shouldBe('Client-side encryption error!');
    }

    public function it_should_describe_client_side_encryption_not_enabled_error()
    {
        $this::getErrorDescription(751)->shouldBe('Client-side Encryption is not enabled!');
    }
}
