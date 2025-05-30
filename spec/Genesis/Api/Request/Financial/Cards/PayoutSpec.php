<?php

namespace spec\Genesis\Api\Request\Financial\Cards;

use Genesis\Api\Constants\Transaction\Parameters\DigitalAssetTypes;
use Genesis\Api\Constants\Transaction\Parameters\Payout\MoneyTransferTypes;
use Genesis\Api\Request\Financial\Cards\Payout;
use Genesis\Exceptions\InvalidMethod;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\AccountOwnerAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\CustomerIdentificationExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\CredentialOnFileAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\CreditCardAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\Financial\CryptoAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\DescriptorAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\FxRateAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\GamingAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\MotoAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\PurposeOfPaymentAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\SourceOfFundsAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\TokenizationAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\UcofAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;
use spec\SharedExamples\Genesis\Api\Traits\Request\DigitalAssetTypeAttributesExamples;
use spec\SharedExamples\Genesis\Api\Traits\Request\DocumentAttributesExample;

class PayoutSpec extends ObjectBehavior
{
    use AccountOwnerAttributesExamples;
    use CredentialOnFileAttributesExamples;
    use CredentialOnFileAttributesExamples;
    use CreditCardAttributesExamples;
    use CustomerIdentificationExamples;
    use DescriptorAttributesExample;
    use DocumentAttributesExample;
    use FxRateAttributesExamples;
    use NeighborhoodAttributesExamples;
    use PurposeOfPaymentAttributesExamples;
    use RequestExamples;
    use SourceOfFundsAttributesExamples;
    use TokenizationAttributesExamples;
    use UcofAttributesExamples;
    use DigitalAssetTypeAttributesExamples;
    use CryptoAttributesExamples;
    use GamingAttributesExamples;
    use MotoAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Payout::class);
    }

    public function it_should_fail_when_set_invalid_money_transfer_type()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setMoneyTransferType', ['invalid']);
    }

    public function it_should_fail_when_set_invalid_service_provider_name()
    {
        $this->setRequestParameters();
        $this->setMoneyTransferRequiredParameters();
        $this->shouldThrow()->during('setMoneyTransferServiceProviderName', [
                str_repeat(
                    '*',
                    Payout::MONEY_TRANSFER_SENDER_ACCOUNT_NUMBER_MAX_LENGTH + 1
                )
            ]);
    }

    public function it_should_fail_when_set_invalid_sender_account_number()
    {
        $this->setRequestParameters();
        $this->setMoneyTransferRequiredParameters();
        $this->shouldThrow()->during('setMoneyTransferSenderAccountNumber', [
            str_repeat(
                '*',
                Payout::MONEY_TRANSFER_SENDER_ACCOUNT_NUMBER_MAX_LENGTH + 1
            )
        ]);
    }

    public function it_should_fail_when_set_money_transfer_type_without_required_fields()
    {
        $this->setRequestParameters();
        $this->setMoneyTransferType($this->getFaker()->randomElement(
            MoneyTransferTypes::getAllowedMoneyTransferTypes()
        ));
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_not_fail_when_set_required_parameters()
    {
        $this->setRequestParameters();
        $this->setMoneyTransferRequiredParameters();
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_with_missing_state_for_us_ca_country()
    {
        $this->setRequestParameters();
        $this->setMoneyTransferRequiredParameters();
        $this->setMoneyTransferSenderCountry(
            $this->getFaker()->randomElement(['US', 'CA'])
        );
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_throw_when_set_scheme_tokenized()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setSchemeTokenized');
    }

    public function it_should_throw_when_get_scheme_tokenized()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('getSchemeTokenized');
    }

    public function it_should_throw_when_credential_on_file_settlement_date()
    {
        $this->shouldThrow(InvalidMethod::class)->duringSetCredentialOnFileSettlementDate('value');
        $this->shouldThrow(InvalidMethod::class)->duringGetCredentialOnFileSettlementDate();
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

    private function setMoneyTransferRequiredParameters()
    {
        $faker = $this->getFaker();
        $this->setMoneyTransferType($faker->randomElement(
            MoneyTransferTypes::getAllowedMoneyTransferTypes()
        ));
        $this->setMoneyTransferSenderAccountNumber('DE91100000000123456789');
        $this->setMoneyTransferServiceProviderName('eMPPay');
        $this->setMoneyTransferSenderBirthDate($faker->date('d-m-Y'));
        $this->setMoneyTransferSenderFirstName($faker->firstName);
        $this->setMoneyTransferSenderLastName($faker->lastName);
        $this->setMoneyTransferSenderCountry('UK');
        $this->setMoneyTransferSenderCity($faker->city);
        $this->setMoneyTransferSenderZipCode($faker->postcode);
        $this->setMoneyTransferSenderAddress1($faker->address);
        $this->setDigitalAssetType($this->getFaker()->randomElement(DigitalAssetTypes::getAll()));
    }
}
