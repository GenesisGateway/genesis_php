<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking;

use Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking\Payin;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class PayinSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Payin::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'remote_ip',
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url'
        ]);
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setBankCode('GDB');
        $this->setCurrency('CNY');
        $this->setBillingCountry($this->getFaker()->countryCode);
    }

    public function it_should_fail_when_wrong_currency_param()
    {
        $this->setRequestParameters();
        $this->setCurrency('USD');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_required_bank_code_is_missing()
    {
        $this->setRequestParameters();
        $this->setBankCode('');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_missing_billing_state_for_US_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('US');
        $this->setBillingState(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_billing_state_for_CA_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('CA');
        $this->setBillingState(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_invalid_payment_type_param()
    {
        $this->shouldThrow()->during('setPaymentType', ['fake_type']);
    }

    public function it_should_succeed_when_valid_payment_type_param()
    {
        $this->shouldNotThrow()->during('setPaymentType', [Payin::PAYMENT_TYPE_QR_PAYMENT]);
    }
}
