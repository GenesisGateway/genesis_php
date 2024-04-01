<?php

namespace spec\Genesis\API\Request\Financial\Payout;

use Genesis\API\Request\Financial\Payout\RussianMobilePayout;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\NeighborhoodAttributesExamples;

class RussianMobilePayoutSpec extends ObjectBehavior
{
    use RequestExamples, NeighborhoodAttributesExamples;

    public function is_it_initializable()
    {
        $this->shouldHaveType(RussianMobilePayout::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'customer_phone',
            'billing_country'
        ]);
    }

    public function it_should_fail_when_set_invalid_currency()
    {
        $this->setRequestParameters();
        $this->setCurrency('GBP');
        $this->shouldThrow()->during('getDocument');

        $this->setCurrency($this->getFaker()->uuid);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_set_invalid_billing_country()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('UK');
        $this->shouldThrow()->during('getDocument');

        $this->setBillingCountry($this->getFaker()->uuid);
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setDefaultRequestParameters();
        $this->setCurrency('RUB');
        $this->setBillingCountry('RU');
        $this->setCustomerPhone($faker->phoneNumber);
    }
}
