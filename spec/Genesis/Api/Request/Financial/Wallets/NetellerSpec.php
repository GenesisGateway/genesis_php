<?php

namespace spec\Genesis\Api\Request\Financial\Wallets;

use Genesis\Api\Request\Financial\Wallets\Neteller;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class NetellerSpec extends ObjectBehavior
{
    use NeighborhoodAttributesExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Neteller::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'customer_account',
            'account_password',
            'billing_country',
        ]);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis Automated PHP Request');
        $this->setRemoteIp($faker->ipv4);

        $this->setCurrency(
            $faker->randomElement(
                \Genesis\Utils\Currency::getList()
            )
        );
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));

        $this->setCustomerEmail($faker->email);

        $this->setCustomerAccount($faker->uuid);

        $this->setAccountPassword($faker->realText());

        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);

        $this->setBillingCountry(
            $faker->randomElement(
                \Genesis\Utils\Country::getList()
            )
        );
    }
}
