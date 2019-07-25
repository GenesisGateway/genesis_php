<?php

namespace spec\Genesis\API\Request\Financial\Alternatives;

use Genesis\API\Request\Financial\Alternatives\PaypalExpress;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class PaypalExpressSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(PaypalExpress::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'amount',
            'currency',
            'billing_country'
        ]);
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency(
            $this->getFaker()->randomElement(
                \Genesis\Utils\Currency::getList()
            )
        );
        $this->setBillingCountry(
            $this->getFaker()->randomElement(
                \Genesis\Utils\Country::getList()
            )
        );
    }
}
