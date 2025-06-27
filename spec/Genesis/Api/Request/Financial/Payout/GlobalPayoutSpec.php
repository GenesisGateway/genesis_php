<?php

namespace spec\Genesis\Api\Request\Financial\Payout;

use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class GlobalPayoutSpec extends ObjectBehavior
{
    use RequestExamples;

    public function is_it_initializable()
    {
        $this->shouldHaveType(GlobalPayout::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'amount',
            'currency',
            'payee_account_id'
        ]);
    }

    public function it_should_contain_payee_account_id()
    {
        $id = $this->getFaker()->uuid();

        $this->setRequestParameters();
        $this->setPayeeAccountId($id);

        $this->getDocument()->shouldContain("<payee_account_id>{$id}</payee_account_id>");
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency('USD');
        $this->setPayeeAccountId($faker->uuid());
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingAddress1($faker->streetAddress);
        $this->setBillingAddress2($faker->streetAddress);
        $this->setBillingZipCode($faker->postcode);
        $this->setBillingCity($faker->city);
        $this->setBillingNeighborhood($faker->city);
        $this->setBillingState($faker->state);
        $this->setBillingCountry('NL');
    }
}
