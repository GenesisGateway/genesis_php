<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments;

use Genesis\API\Request\Financial\OnlineBankingPayments\Eps;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\Financial\AsyncAttributesExample;
use spec\SharedExamples\Genesis\API\Request\Financial\PendingPaymentAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\NeighborhoodAttributesExamples;

class EpsSpec extends ObjectBehavior
{
    use RequestExamples, AsyncAttributesExample, PendingPaymentAttributesExamples, NeighborhoodAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Eps::class);
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency('EUR');
        $this->setBillingCountry('AT');
    }

    public function it_should_fail_when_unsupported_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('ZZ');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_unsupported_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('ABC');

        $this->shouldThrow()->during('getDocument');
    }
}
