<?php

namespace spec\Genesis\Api\Request\Financial\Vouchers;

use Genesis\Api\Request\Financial\Vouchers\CashU;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class CashUSpec extends ObjectBehavior
{
    use NeighborhoodAttributesExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(CashU::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'currency',
            'billing_country'
        ]);
    }

    public function it_should_fail_when_wrong_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('LT');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_wrong_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('GBP');
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency('USD');
        $this->setBillingCountry('US');
    }
}
