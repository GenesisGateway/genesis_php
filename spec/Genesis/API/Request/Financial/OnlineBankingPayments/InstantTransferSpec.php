<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments;

use Genesis\API\Request\Financial\OnlineBankingPayments\InstantTransfer;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class InstantTransferSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(InstantTransfer::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'amount',
            'currency',
            'billing_country',
            'return_success_url',
            'return_failure_url'
        ]);
    }

    public function it_should_fail_when_country_not_valid_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('BG');
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency('EUR');
        $this->setBillingCountry('DE');
    }

    public function it_should_fail_when_de_iban_invalid_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('DE');
        $this->shouldThrow()->during('setIban', ['BG1234']);
    }

    public function it_should_set_de_iban_correctly()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('DE');
        $this->shouldNotThrow()->during('setIban', ['DE12345678901234567890']);
    }
}
