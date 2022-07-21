<?php

namespace spec\Genesis\API\Request\Financial\Mobile;

use Genesis\API\Request\Financial\Mobile\AfricanMobileSale;
use Genesis\Utils\Country;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class AfricanMobileSaleSpec extends ObjectBehavior
{
    use RequestExamples;

    public function is_it_initializable()
    {
        $this->setRequestParameters();
        $this->shouldHaveType(AfricanMobileSale::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'operator',
            'target',
            'customer_phone',
            'billing_country'
        ]);
    }

    public function it_should_fail_when_set_invalid_operator()
    {
        $this->setRequestParameters();
        $this->setOperator($this->getFaker()->ipv4);
        $this->shouldThrow()->during('getDocument');
        $this->shouldThrow()->during('setOperator', [$this->getFaker()->uuid]);
    }

    public function it_should_fail_when_set_invalid_target()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setTarget', [$this->getFaker()->uuid]);
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
        $this->setBillingCountry('JP');
        $this->shouldThrow()->during('getDocument');

        $this->setBillingCountry($this->getFaker()->uuid);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_set_invalid_currency_country_operator()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('GH');
        $this->setCurrency('KES');
        $this->setOperator('VODACOM');
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setDefaultRequestParameters();
        $this->setBillingCountry('UG');
        $this->setCurrency('UGX');
        $this->setOperator('MTN');
        $this->setTarget($faker->randomNumber(5));
        $this->setCustomerPhone($faker->phoneNumber);
    }
}
