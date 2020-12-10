<?php

namespace spec\Genesis\API\Request\Financial\Mobile;

use Genesis\API\Request\Financial\Mobile\ApplePay;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Country;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\Financial\CryptoAttributesExamples;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use Genesis\API\Traits\Request\Mobile\ApplePayAttributes;
use Genesis\API\Constants\Transaction\Parameters\Mobile\ApplePayParameters;

class ApplePaySpec extends ObjectBehavior
{
    use RequestExamples, ApplePayAttributes, CryptoAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(ApplePay::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'payment_type',
            'token_version',
            'token_data',
            'token_signature',
            'token_ephemeral_public_key',
            'token_public_key_hash',
            'token_transaction_id',
            'token_display_name',
            'token_network',
            'token_type',
            'token_transaction_identifier',
        ]);
    }

    public function it_should_not_fail_when_unset_birth_date()
    {
        $this->shouldNotThrow()->during('setBirthDate', [null]);
    }

    public function it_should_not_fail_with_proper_birth_date_format()
    {
        $faker = $this->getFaker();
        $this->shouldNotThrow()->during(
            'setBirthDate',
            [$faker->dateTimeThisYear()->format(ApplePay::BIRTH_DATE_FORMAT)]
        );
    }

    public function it_should_fail_with_invalid_birth_date_format()
    {
        $faker = $this->getFaker();
        $this->shouldThrow(InvalidArgument::class)->during(
        'setBirthDate',
            [$faker->dateTimeThisYear()->format('d/m/Y')]
        );
     }

    public function it_should_return_string_birth_date_value()
    {
        $this->setBirthDate('01-01-2020');
        $this->getBirthDate()->shouldBeString();
    }

    public function it_should_throw_when_is_set_wrong_payment_type_parameter()
    {
        $this->setRequestParameters();
        $this->setPaymentType('test_type');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->uuid);
        $this->setPaymentType($faker->randomElement(
            ApplePayParameters::getAllowedPaymentTypes()
        ));
        $this->setTokenVersion($faker->word);
        $this->setTokenData($faker->text);
        $this->setTokenSignature($faker->sha256);
        $this->setTokenEphemeralPublicKey($faker->sha256);
        $this->setTokenPublicKeyHash($faker->sha256);
        $this->setTokenTransactionId($faker->uuid);
        $this->setTokenDisplayName($faker->name);
        $this->setTokenNetwork($faker->word);
        $this->setTokenType($faker->word);
        $this->setTokenTransactionIdentifier($faker->sha256);
        $this->setCurrency(
            $faker->randomElement(
                 \Genesis\Utils\Currency::getList()
            )
        );
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Apple Pay Request');
        $this->setRemoteIp($faker->ipv4);
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
