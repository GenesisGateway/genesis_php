<?php

namespace spec\Genesis\Api\Request\Financial\Mobile;

use Genesis\Api\Request\Financial\Mobile\ApplePay;
use Genesis\Api\Traits\Request\Mobile\ApplePayAttributes;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\Financial\Business\BusinessAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\Cards\Recurring\RecurringTypeAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\CryptoAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\DescriptorAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\FundingAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;
use spec\SharedExamples\Genesis\Api\Traits\Request\DocumentAttributesExample;
use spec\SharedExamples\Genesis\Api\Traits\Request\Financial\BirthDateAttributesExample;

class ApplePaySpec extends ObjectBehavior
{
    use BirthDateAttributesExample;
    use BusinessAttributesExample;
    use CryptoAttributesExamples;
    use DescriptorAttributesExample;
    use DocumentAttributesExample;
    use FundingAttributesExamples;
    use NeighborhoodAttributesExamples;
    use RecurringTypeAttributesExample;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(ApplePay::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'payment_subtype',
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

    public function it_should_throw_when_is_set_wrong_payment_type_parameter()
    {
        $this->setRequestParameters();
        $this->setPaymentSubtype('test_type');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_fail_with_valid_json_token()
    {
        $token = $this->getToken();

        $this->setRequestParameters();
        $this->setTokenAttributesNull();

        $this->shouldNotThrow()->during('setJsonToken', [$token]);
    }

    public function it_should_fail_with_missing_attribute_in_json_token()
    {
        $decodedToken = json_decode($this->getToken(), true);
        $decodedToken['transactionIdentifier'] = null;
        $token = json_encode($decodedToken);

        $this->setRequestParameters();
        $this->setTokenAttributesNull();

        $this->shouldNotThrow()->during('setJsonToken', [$token]);
    }

    public function it_should_fail_with_invalid_json_token()
    {
        $this->setRequestParameters();

        $this->shouldThrow()->during('setJsonToken',
            [Faker::getInstance()->word]
        );
    }

    public function it_should_contain_token_attributes_when_set_token()
    {
        $token = $this->getToken();

        $this->setRequestParameters();
        $this->setTokenAttributesNull();

        $this->setJsonToken($token);
        $this->getDocument()->shouldContain('transactionIdentifier');
        $this->getDocument()->shouldContain('applicationData');
        $this->getDocument()->shouldContain('wrappedKey');
    }

    public function it_should_not_contain_empty_token_elements()
    {
        $this->setRequestParameters();
        $this->setTokenApplicationData('');
        $this->setTokenWrappedKey('');

        $this->getDocument()->shouldNotContain('applicationData');
        $this->getDocument()->shouldNotContain('wrappedKey');
    }

    public function it_should_not_fail_when_zero_amount()
    {
        $this->setRequestParameters();
        $this->setAmount(0);
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_throw_when_null_amount()
    {
        $this->setRequestParameters();
        $this->setAmount(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_throw_when_set_negative_amount()
    {
        $this->setRequestParameters();
        $this->shouldThrow()->during('setAmount', [-10]);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->uuid);
        $this->setPaymentSubtype($faker->randomElement(
            \Genesis\Api\Constants\Transaction\Parameters\Mobile\ApplePay\PaymentTypes::getAllowedPaymentTypes()
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

    private function getToken()
    {
        $faker = Faker::getInstance();

        return json_encode([
            'paymentData' => [
                'version'   => 'EC_v1',
                'data'      => $faker->sha256,
                'signature' => $faker->sha256,
                'header'    => [
                    'applicationData'    => $faker->sha256,
                    'ephemeralPublicKey' => $faker->sha256,
                    'wrappedKey'         => $faker->uuid,
                    'publicKeyHash'      => $faker->sha256,
                    'transactionId'      => $faker->uuid
                ]
            ],
            'paymentMethod' => [
                'displayName' => 'Visa 2222',
                'network'     => 'Visa',
                'type'        => 'debit'
            ],
            'transactionIdentifier' => $faker->md5
        ]);
    }

    private function setTokenAttributesNull()
    {
        $this->setTokenVersion(null);
        $this->setTokenData(null);
        $this->setTokenSignature(null);
        $this->setTokenEphemeralPublicKey(null);
        $this->setTokenPublicKeyHash(null);
        $this->setTokenTransactionId(null);
        $this->setTokenDisplayName(null);
        $this->setTokenNetwork(null);
        $this->setTokenType(null);
        $this->setTokenTransactionIdentifier(null);
    }
}
