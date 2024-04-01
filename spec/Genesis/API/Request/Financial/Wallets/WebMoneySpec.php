<?php

namespace spec\Genesis\API\Request\Financial\Wallets;

use Genesis\API\Request\Financial\Wallets\WebMoney;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\NeighborhoodAttributesExamples;

class WebMoneySpec extends ObjectBehavior
{
    use RequestExamples, NeighborhoodAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(WebMoney::class);
    }

    public function it_should_fail_when_payout_transaction_without_cust_account_id()
    {
        $this->setRequestParameters();
        $this->setIsPayout(true);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_payout_transaction_without_billing_country()
    {
        $this->setRequestParameters();
        $this->setBillingCountry(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_build_payout_structure()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();
        $this->setIsPayout(true);
        $this->setCustomerAccountId($faker->userName);
        $this->getDocument()->shouldNotBeEmpty();
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

        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);

        $this->setBillingCountry(
            $faker->randomElement(
                \Genesis\Utils\Country::getList()
            )
        );
    }
}
