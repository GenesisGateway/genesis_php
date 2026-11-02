<?php

namespace spec\Genesis\Api\Request\Financial\Cards;

use Genesis\Api\Constants\Transaction\Parameters\DigitalAssetTypes;
use Genesis\Api\Constants\Transaction\Parameters\Recurring\Types;
use Genesis\Api\Request\Financial\Cards\Authorize;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Traits\Request\Financial\InstallmentAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\AccountOwnerAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\AllowedZeroAmount;
use spec\SharedExamples\Genesis\Api\Request\Financial\Business\BusinessAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\Recurring\ManagedRecurringAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\Recurring\RecurringCategoryAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\Recurring\RecurringTypeAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\SchemeTokenizedExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\CommercialCardAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\CredentialOnFileAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\CreditCardAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\CryptoAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\DescriptorAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\FundingAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\PurposeOfPaymentAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\FxRateAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\GamingAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\MarketplaceDataAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\MarketplaceDataSubsequentRecurringExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\MotoAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\OrderAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\ScaAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\TokenizationAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\UcofAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\UcofTransactionLinkIdAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;
use spec\SharedExamples\Genesis\Api\Traits\Request\DigitalAssetTypeAttributesExamples;
use spec\SharedExamples\Genesis\Api\Traits\Request\DocumentAttributesExample;
use spec\SharedExamples\Genesis\Api\Traits\Request\Financial\Cards\TokenizationParamsAttributesExamples;

class AuthorizeSpec extends ObjectBehavior
{
    use AccountOwnerAttributesExamples;
    use AllowedZeroAmount;
    use BusinessAttributesExample;
    use CommercialCardAttributesExamples;
    use CredentialOnFileAttributesExamples;
    use CreditCardAttributesExamples;
    use CryptoAttributesExamples;
    use DescriptorAttributesExample;
    use DocumentAttributesExample;
    use FundingAttributesExamples;
    use PurposeOfPaymentAttributesExamples;
    use FxRateAttributesExamples;
    use ManagedRecurringAttributesExample;
    use NeighborhoodAttributesExamples;
    use OrderAttributesExamples;
    use RecurringCategoryAttributesExample;
    use RecurringTypeAttributesExample;
    use RequestExamples;
    use ScaAttributesExamples;
    use TokenizationAttributesExamples;
    use UcofAttributesExamples;
    use UcofTransactionLinkIdAttributesExamples;
    use SchemeTokenizedExamples;
    use InstallmentAttributesExamples;
    use TokenizationParamsAttributesExamples;
    use DigitalAssetTypeAttributesExamples;
    use MotoAttributesExamples;
    use GamingAttributesExamples;
    use MarketplaceDataAttributesExamples;
    use MarketplaceDataSubsequentRecurringExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Authorize::class);
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

        $this->setCardHolder($this->getFaker()->asciify('**** **** *****'));

        $this->shouldNotThrow(
            $this->getExpectedFieldValueException('card_holder')
        )->during('getDocument');
    }

    public function it_can_set_cc_holder_parameter_with_special_chars()
    {
        $this->setRequestParameters();
        $this->setCardHolder($this->getFaker()->asciify('***** *****'));

        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_unsupported_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('ABC');

        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_not_fail_with_subsequent_recurring_type()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setRecurringType(Types::SUBSEQUENT);
        $this->setReferenceId('transaction-reference-id');

        $this->shouldNotThrow()->during('getDocument');
    }

    protected function setPurposeOfPaymentFundingParameters()
    {
        $this->setPurposeOfPaymentRequiredParameters();
        $this->setFundingIdentifierType('account_to_account');
        }
        
        public function it_should_send_subsequent_recurring_commercial_card_amounts_without_currency_as_entered(){
        $faker = $this->getFaker();
        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setRecurringType(Types::SUBSEQUENT);
        $this->setReferenceId('transaction-reference-id');

        $this->setCommercialCardName('Commercial Card Item');
        $this->setCommercialCardQuantity(1);
        $this->setCommercialCardTaxRate('20');
        $this->setCommercialCardUnitPrice('5000');
        $this->setCommercialCardTotalTaxAmount('1000');
        $this->setCommercialCardTotalDiscountAmount('500');

        $document = $this->getDocument();
        $document->shouldContain('<unit_price>5000</unit_price>');
        $document->shouldContain('<total_tax_amount>1000</total_tax_amount>');
        $document->shouldContain('<total_discount_amount>500</total_discount_amount>');
        $document->shouldContain('<tax_rate>2000</tax_rate>');
    }

    public function it_should_fail_with_subsequent_recurring_commercial_card_zero_unit_price_without_currency()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setRecurringType(Types::SUBSEQUENT);
        $this->setReferenceId('transaction-reference-id');

        $this->setCommercialCardName('Commercial Card Item');
        $this->setCommercialCardQuantity(1);
        $this->setCommercialCardTaxRate('20');
        $this->setCommercialCardUnitPrice('0');

        $this->shouldThrow(
            new ErrorParameter('Empty (null) required parameter: commercial_card_unit_price')
        )->during('getDocument');
    }

    public function it_should_convert_subsequent_recurring_commercial_card_unit_price_with_currency()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setRecurringType(Types::SUBSEQUENT);
        $this->setReferenceId('transaction-reference-id');
        $this->setCurrency('EUR');

        $this->setCommercialCardName('Commercial Card Item');
        $this->setCommercialCardQuantity(1);
        $this->setCommercialCardTaxRate('20');
        $this->setCommercialCardUnitPrice('50.00');
        $this->setCommercialCardTotalTaxAmount('10.00');
        $this->setCommercialCardTotalDiscountAmount('5.00');

        $this->getDocument()->shouldContain('<unit_price>5000</unit_price>');
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
        $this->setTokenizationTavv($faker->numberBetween(1, 9999999));
        $this->setTokenizationEci($faker->numberBetween(1, 99));
        $this->setDigitalAssetType($this->getFaker()->randomElement(DigitalAssetTypes::getAll()));
    }
}
