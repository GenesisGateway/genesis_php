<?php

namespace spec\Genesis\Api\Request\Financial\OnlineBankingPayments;

use Genesis\Api\Request\Financial\OnlineBankingPayments\SafetyPay;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\AsyncAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\PendingPaymentAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class SafetyPaySpec extends ObjectBehavior
{
    use AsyncAttributesExample;
    use NeighborhoodAttributesExamples;
    use PendingPaymentAttributesExamples;
    use RequestExamples;

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
