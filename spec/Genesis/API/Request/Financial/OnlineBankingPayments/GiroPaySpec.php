<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments;

use Genesis\API\Request\Financial\OnlineBankingPayments\GiroPay;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class GiroPaySpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(GiroPay::class);
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCustomerPhone($this->getFaker()->phoneNumber);
        $this->setBic('AGB3SSWI');
        $this->setIban('DE12345678901234567890');
        $this->setCurrency('EUR');
        $this->setBillingCountry('DE');
    }

    public function it_should_fail_when_unsupported_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('ABC');

        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setBic', [null]);
    }

    public function it_should_fail_when_unsupported_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('ZZ');
        $this->shouldThrow()->during('getDocument');
    }
}
