<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments;

use Genesis\API\Request\Financial\OnlineBankingPayments\GiroPay;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\Financial\AsyncAttributesExample;
use spec\SharedExamples\Genesis\API\Request\Financial\PendingPaymentAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class GiroPaySpec extends ObjectBehavior
{
    use RequestExamples, AsyncAttributesExample, PendingPaymentAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(GiroPay::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url',
            'billing_country'
        ]);
    }

    public function it_should_fail_when_unsupported_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('ABC');

        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_missing_optional_parameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency('EUR');
        $this->setBillingCountry('DE');
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_contain_proper_structure_with_optional_parameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency('EUR');
        $this->setBillingCountry('DE');

        $this->setBic('AGB3SSWI');
        $this->getDocument()->shouldContain('<bic>AGB3SSWI</bic>');

        $this->setIban('DE12345678901234567890');
        $this->getDocument()->shouldContain('<iban>DE12345678901234567890</iban>');
    }

    public function it_should_contain_proper_structure_without_optional_parameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency('EUR');
        $this->setBillingCountry('DE');

        $this->getDocument()->shouldNotContain('<bic>');
        $this->getDocument()->shouldNotContain('<iban>');
    }

    public function it_should_fail_when_unsupported_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('ZZ');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_with_incorrect_iban()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency('EUR');
        $this->setBillingCountry('DE');
        $this->setIban('INCORRECT');
        $this->shouldThrow()->during('getDocument');
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
}
