<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments;

use Genesis\API\Request\Financial\OnlineBankingPayments\SafetyPay;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\Financial\AsyncAttributesExample;
use spec\SharedExamples\Genesis\API\Request\Financial\PendingPaymentAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\NeighborhoodAttributesExamples;

class SafetyPaySpec extends ObjectBehavior
{
    use RequestExamples, AsyncAttributesExample, PendingPaymentAttributesExamples, NeighborhoodAttributesExamples;

    private $allowedCountries = ['AT', 'BE', 'BR', 'CL', 'CO', 'DE', 'EC', 'ES', 'MX', 'NL', 'PE', 'PR'];

    public function it_is_initializable()
    {
        $this->shouldHaveType(SafetyPay::class);
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

    public function it_should_not_fail_with_valid_country()
    {
        $this->setRequestParameters();

        foreach ($this->allowedCountries as $country) {
            $this->setBillingCountry($country);

            $this->shouldNotThrow()->during('getDocument');
        }
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency('USD');
        $this->setBillingCountry('BR');
    }
}
