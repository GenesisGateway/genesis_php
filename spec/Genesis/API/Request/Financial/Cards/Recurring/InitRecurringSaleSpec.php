<?php

namespace spec\Genesis\API\Request\Financial\Cards\Recurring;

use Genesis\API\Request\Financial\Cards\Recurring\InitRecurringSale;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\Financial\AllowedZeroAmount;
use spec\SharedExamples\Genesis\API\Request\Financial\Business\BusinessAttributesExample;
use spec\SharedExamples\Genesis\API\Request\Financial\CredentialOnFileAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\DescriptorAttributesExample;
use spec\SharedExamples\Genesis\API\Request\Financial\FxRateAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\TokenizationAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Traits\Request\DocumentAttributesExample;
use spec\SharedExamples\Genesis\API\Request\Financial\Cards\Recurring\ManagedRecurringAttributesExample;

class InitRecurringSaleSpec extends ObjectBehavior
{
    use RequestExamples, FxRateAttributesExamples, DescriptorAttributesExample,
        TokenizationAttributesExamples, BusinessAttributesExample, CredentialOnFileAttributesExamples,
        AllowedZeroAmount, DocumentAttributesExample, ManagedRecurringAttributesExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(InitRecurringSale::class);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency(
            $faker->randomElement(
                \Genesis\Utils\Currency::getList()
            )
        );
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setCardHolder($faker->name);
        $this->setCardNumber('4200000000000000');
        $this->setCvv(sprintf("%03s", $faker->numberBetween(1, 999)));
        $this->setExpirationMonth($faker->numberBetween(01, 12));
        $this->setExpirationYear($faker->numberBetween(date('Y'), date('Y') + 5));
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
