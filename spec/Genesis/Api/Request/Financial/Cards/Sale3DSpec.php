<?php

namespace spec\Genesis\Api\Request\Financial\Cards;

use Genesis\Api\Request\Financial\Cards\Sale3D;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\AccountOwnerAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\AllowedZeroAmount;
use spec\SharedExamples\Genesis\Api\Request\Financial\Business\BusinessAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\Recurring\ManagedRecurringAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\Recurring\RecurringCategoryAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\Recurring\RecurringTypeAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\CredentialOnFileAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\CreditCardAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\CryptoAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\DescriptorAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\FundingAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\FxRateAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\MpiAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\ScaAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\Threeds\V2\ThreedsV2AttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\TokenizationAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;
use spec\SharedExamples\Genesis\Api\Traits\Request\DocumentAttributesExample;

class Sale3DSpec extends ObjectBehavior
{
    use AccountOwnerAttributesExamples;
    use AllowedZeroAmount;
    use BusinessAttributesExample;
    use CredentialOnFileAttributesExamples;
    use CreditCardAttributesExamples;
    use CryptoAttributesExamples;
    use DescriptorAttributesExample;
    use DocumentAttributesExample;
    use FundingAttributesExamples;
    use FxRateAttributesExamples;
    use ManagedRecurringAttributesExample;
    use MpiAttributesExamples;
    use NeighborhoodAttributesExamples;
    use RecurringCategoryAttributesExample;
    use RecurringTypeAttributesExample;
    use RequestExamples;
    use ScaAttributesExamples;
    use ThreedsV2AttributesExamples;
    use TokenizationAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Sale3D::class);
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setCardNumber(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_can_build_with_reference_id_parameter()
    {
        $this->setRequestParameters();
        $this->setReferenceId('transaction-reference-id');
        $this->getReferenceId()->shouldBe('transaction-reference-id');
        $this->getDocument()->shouldContain('transaction-reference-id');
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
        $this->setMpi3DSv1();
    }
}
