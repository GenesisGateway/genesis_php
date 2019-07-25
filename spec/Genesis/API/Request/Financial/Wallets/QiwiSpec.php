<?php

namespace spec\Genesis\API\Request\Financial\Wallets;

use Genesis\API\Request\Financial\Wallets\Qiwi;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class QiwiSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Qiwi::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'return_success_url',
            'return_failure_url',
            'amount',
            'billing_country'
        ]);
    }

    public function it_should_fail_when_country_not_valid_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('BG');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_country_currency_not_valid_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('RU');
        $this->setCurrency('USD');
        $this->shouldThrow()->during('getDocument');
        $this->setBillingCountry('UA');
        $this->setCurrency('EUR');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_customer_phone_not_valid_param()
    {
        $this->setRequestParameters();
        $this->setCustomerPhone('+1234');
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCustomerPhone('+7123456789');
        $this->setCurrency('EUR');
        $this->setBillingCountry('RU');
    }
}
