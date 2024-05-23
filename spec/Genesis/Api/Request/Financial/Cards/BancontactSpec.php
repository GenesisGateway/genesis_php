<?php

namespace spec\Genesis\Api\Request\Financial\Cards;

use Genesis\Api\Request\Financial\Cards\Bancontact;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class BancontactSpec extends ObjectBehavior
{
    use NeighborhoodAttributesExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Bancontact::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'billing_country'
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
        $this->setBillingCountry('BE');
    }
}
