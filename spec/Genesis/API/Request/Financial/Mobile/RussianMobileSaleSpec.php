<?php

namespace spec\Genesis\API\Request\Financial\Mobile;

use Genesis\API\Constants\Transaction\Parameters\RussianMobileOperators;
use Genesis\API\Request\Financial\Mobile\RussianMobileSale;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class RussianMobileSaleSpec extends ObjectBehavior
{
    use RequestExamples;

    public function is_it_initializable()
    {
        $this->shouldHaveType(RussianMobileSale::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'usage',
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

    public function it_should_fail_when_set_invalid_usage()
    {
        $this->shouldThrow()->during('setUsage', [$this->getFaker()->uuid]);
    }

    public function it_should_fail_when_set_invalid_operator()
    {
        $this->setRequestParameters();
        $this->setOperator($this->getFaker()->ipv4);
        $this->shouldThrow()->during('getDocument');
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

        $this->setTransactionId($faker->uuid);
        $this->setUsage(strval($faker->randomNumber(5)));
        $this->setCurrency('RUB');
        $this->setBillingCountry('RU');
        $this->setOperator($faker->randomElement(RussianMobileOperators::getAll()));
        $this->setTarget($faker->randomNumber());
        $this->setRemoteIp($faker->ipv4);
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCustomerEmail($faker->email);
        $this->setCustomerPhone($faker->phoneNumber);
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingAddress1($faker->streetAddress);
        $this->setBillingZipCode($faker->postcode);
        $this->setBillingCity($faker->city);
        $this->setBillingState($faker->state);
    }
}
