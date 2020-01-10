<?php

namespace spec\Genesis\API\Request\Financial\Wallets;

use Faker\Factory;
use Faker\Generator;
use Genesis\API\Request\Financial\Wallets\Zimpler;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class ZimplerSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Zimpler::class);
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

    public function it_should_fail_when_invalid_currency()
    {
        $this->setRequestParameters();
        $this->setCurrency('USD');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_invalid_country()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('BG');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_customer_email()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setCustomerEmail', ['null']);
    }

    public function it_should_set_billing_country_correctly()
    {
        $this->setRequestParameters();

        $this->setBillingCountry('FI');
        $this->shouldNotThrow()->during('getDocument');

        $this->setBillingCountry('SE');
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_set_currency_correctly()
    {
        $this->setRequestParameters();

        $this->setCurrency('EUR');
        $this->shouldNotThrow()->during('getDocument');

        $this->setCurrency('SEK');
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_when_customer_phone_is_not_set()
    {
        $this->setRequestParameters();
        $this->setCustomerPhone(null);

        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setRequestBaseParameters($faker);
        $this->setRequestCurrencyParameters($faker);
        $this->setRequestCustomerParameters($faker);
        $this->setRequestReturnUrlParameters($faker);

        $this->setBillingCountry('FI');
    }

    protected function setRequestBaseParameters(Generator $faker)
    {
        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis Automated PHP Request');
    }

    protected function setRequestCurrencyParameters(Generator $faker)
    {
        $this->setCurrency('EUR');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
    }

    protected function setRequestCustomerParameters(Generator $faker)
    {
        $this->setCustomerEmail($faker->email);
        $this->setCustomerPhone($faker->phoneNumber);
    }

    protected function setRequestReturnUrlParameters(Generator $faker)
    {
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
    }
}
