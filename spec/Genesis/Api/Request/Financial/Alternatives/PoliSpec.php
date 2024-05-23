<?php

namespace spec\Genesis\Api\Request\Financial\Alternatives;

use Genesis\Api\Request\Financial\Alternatives\Poli;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class PoliSpec extends ObjectBehavior
{
    use NeighborhoodAttributesExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Poli::class);
    }

    public function it_should_fail_when_missing_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_wrong_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('US');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_wrong_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('USD');
        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis Automated PHP Request');
        $this->setRemoteIp($faker->ipv4);

        $this->setCurrency('AUD');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));

        $this->setCustomerEmail($faker->email);

        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);

        $this->setBillingCountry('AU');
    }
}
