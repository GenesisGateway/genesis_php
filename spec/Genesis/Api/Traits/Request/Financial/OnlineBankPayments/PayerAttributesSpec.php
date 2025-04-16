<?php

namespace spec\Genesis\Api\Traits\Request\Financial\OnlineBankPayments;

use PhpSpec\ObjectBehavior;
use Genesis\Exceptions\InvalidArgument;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\OnlineBankingPayments\PayerAttributesStub;

class PayerAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(PayerAttributesStub::class);
    }

    public function it_should_set_payer_document_id()
    {
        $this->shouldNotThrow()->during('setPayerDocumentId', [str_repeat('a', 15)]);
    }

    public function it_should_throw_when_invalid_payer_document_id()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setPayerDocumentId',
            [str_repeat('a', 20)]
        );
    }

    public function it_should_set_payer_bank_code()
    {
        $this->shouldNotThrow()->during('setPayerBankCode', [str_repeat('b', 11)]);
    }

    public function it_should_throw_when_invalid_bank_code()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setPayerBankCode',
            [str_repeat('b', 20)]
        );
    }

    public function it_should_set_payer_bank_account_number()
    {
        $this->shouldNotThrow()->during('setPayerBankAccountNumber', [str_repeat('c', 33)]);
    }

    public function it_should_throw_when_invalid_payer_bank_account_number()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setPayerBankAccountNumber',
            [str_repeat('c', 40)]
        );
    }

    public function it_should_set_payer_bank_branch()
    {
        $this->shouldNotThrow()->during('setPayerBankBranch', [str_repeat('d', 10)]);
    }

    public function it_should_throw_when_invalid__payer_bank_branch()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setPayerBankBranch',
            [str_repeat('d', 20)]
        );
    }

    public function it_should_set_payer_bank_account_verification_digit()
    {
        $this->shouldNotThrow()->during('setPayerBankAccountVerificationDigit', ['1']);
    }

    public function it_should_throw_when_invalid_payer_bank_account_verification_digit()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setPayerBankAccountVerificationDigit',
            ['123']
        );
    }

    public function it_should_set_and_get_payer_bank_phone_number()
    {
        // 11 characters is valid for payer_bank_phone_number (limit: 11)
        $this->shouldNotThrow()->during('setPayerBankPhoneNumber', [str_repeat('1', 11)]);
    }

    public function it_should_throw_when_invalid_payer_bank_phone_number()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setPayerBankPhoneNumber',
            [str_repeat('1', 20)]
        );
    }
}
