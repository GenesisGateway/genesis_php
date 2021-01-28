<?php

namespace spec\Genesis\API\Request\NonFinancial;

use Genesis\API\Request\NonFinancial\AccountVerification;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\Financial\CredentialOnFileAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class AccountVerificationSpec extends ObjectBehavior
{
    use RequestExamples, CredentialOnFileAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(AccountVerification::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'card_holder'
        ]);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId(mt_rand(PHP_INT_SIZE, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setCardHolder($faker->name);
        $this->setCardNumber('4200000000000000');
        $this->setCvv(sprintf("%03s", mt_rand(1, 999)));
        $this->setExpirationMonth(mt_rand(01, 12));
        $this->setExpirationYear(mt_rand(2015, 2020));
        $this->setCustomerEmail($faker->email);
        $this->setCustomerPhone($faker->phoneNumber);
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingAddress1($faker->streetAddress);
        $this->setBillingZipCode($faker->postcode);
        $this->setBillingCity($faker->city);
        $this->setBillingState($faker->state);
        $this->setBillingCountry($faker->countryCode);
    }
}
