<?php

namespace spec\Genesis\Api\Request\Financial\Cards;

use Genesis\Api\Constants\Transaction\Parameters\DigitalAssetTypes;
use Genesis\Api\Request\Financial\Cards\Authorize3D;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Traits\Request\Financial\InstallmentAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\AccountOwnerAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\AllowedZeroAmount;
use spec\SharedExamples\Genesis\Api\Request\Financial\Business\BusinessAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\Recurring\ManagedRecurringAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\Recurring\RecurringCategoryAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\Recurring\RecurringTypeAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\SchemeTokenized3DExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\ThreedsV2DatesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\CredentialOnFileAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\CreditCardAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\CryptoAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\DescriptorAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\FundingAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\FxRateAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\GamingAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\MotoAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\MpiAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\ScaAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\Threeds\V2\ThreedsV2AttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\TokenizationAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\UcofAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;
use spec\SharedExamples\Genesis\Api\Traits\Request\DigitalAssetTypeAttributesExamples;
use spec\SharedExamples\Genesis\Api\Traits\Request\DocumentAttributesExample;
use spec\SharedExamples\Genesis\Api\Traits\Request\Financial\Cards\TokenizationParamsAttributesExamples;

class Authorize3DSpec extends ObjectBehavior
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
    use ThreedsV2DatesExamples;
    use TokenizationAttributesExamples;
    use UcofAttributesExamples;
    use SchemeTokenized3DExamples;
    use InstallmentAttributesExamples;
    use TokenizationParamsAttributesExamples;
    use DigitalAssetTypeAttributesExamples;
    use MotoAttributesExamples;
    use GamingAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Authorize3D::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'card_holder',
            'card_number'
        ]);
    }

    public function it_should_fail_when_missing_cc_holder_last_name_parameter()
    {
        $this->setRequestParameters();
        $this->setCardHolder($this->getFaker()->firstName);

        $this->shouldThrow(
            $this->getExpectedFieldValueException('card_holder')
        )->during('getDocument');
    }

    public function it_should_not_fail_with_special_chars_for_cc_holder_parameter()
    {
        $this->setRequestParameters();
        $this->setCardHolder($this->getFaker()->asciify('**** ***** ****'));

        $this->shouldNotThrow(
            $this->getExpectedFieldValueException('card_holder')
        )->during('getDocument');
    }

    public function it_can_set_cc_holder_parameter_with_special_chars()
    {
        $this->setRequestParameters();
        $this->setCardHolder($this->getFaker()->asciify('**** ****'));

        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_unsupported_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('ABC');

        $this->shouldThrow()->during('getDocument');
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
        $this->setExpirationMonth($faker->numberBetween(1, 12));
        $this->setExpirationYear($faker->numberBetween(date('Y'), 2020));
        $this->setCustomerEmail($faker->email);
        $this->setCustomerPhone($faker->phoneNumber);
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingAddress1($faker->streetAddress);
        $this->setBillingZipCode($faker->postcode);
        $this->setBillingCity($faker->city);
        $this->setBillingState($faker->state);
        $this->setBillingCountry($faker->countryCode);
        $this->setNotificationUrl($faker->url);
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setTokenizationTavv($faker->numberBetween(1, 9999999));
        $this->setTokenizationEci($faker->numberBetween(1, 99));
        $this->setDigitalAssetType($this->getFaker()->randomElement(DigitalAssetTypes::getAll()));
    }
}
