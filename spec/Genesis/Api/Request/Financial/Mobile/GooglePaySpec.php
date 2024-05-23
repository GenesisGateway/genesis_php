<?php

namespace spec\Genesis\Api\Request\Financial\Mobile;

use Genesis\Api\Constants\Transaction\Parameters\Mobile\GooglePay\PaymentTypes;
use Genesis\Api\Request\Financial\Mobile\GooglePay;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\Financial\AsyncAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\DescriptorAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\NotificationAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\Financial\Threeds\V2\ThreedsV2AttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;
use spec\SharedExamples\Genesis\Api\Traits\Request\DocumentAttributesExample;

class GooglePaySpec extends ObjectBehavior
{
    use AsyncAttributesExample;
    use DescriptorAttributesExample;
    use DocumentAttributesExample;
    use NeighborhoodAttributesExamples;
    use NotificationAttributesExamples;
    use RequestExamples;
    use ThreedsV2AttributesExamples;

    public function is_it_initializable()
    {
        $this->shouldHaveType(GooglePay::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'payment_subtype',
            'amount',
            'currency',
            'token_signature',
            'token_signed_key',
            'token_signatures',
            'token_protocol_version',
            'token_signed_message'
        ]);
    }

    public function it_should_throw_when_is_set_wrong_payment_type_parameter()
    {
        $this->setRequestParameters();
        $this->setPaymentSubtype('invalid_type');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_contain_optional_business_attributes()
    {
        $this->setRequestParameters();
        $this->setBusinessEventStartDate(Faker::getInstance()->date());
        $this->getDocument()->shouldContain('business_attributes');
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
        $decodedToken['signature'] = null;
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
        $this->getDocument()->shouldContain('protocolVersion');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->uuid);
        $this->setPaymentSubtype($faker->randomElement(
            PaymentTypes::getAllowedPaymentTypes()
        ));
        $this->setAmount($faker->numberBetween(1, 10000));
        $this->setCurrency($faker->randomElement(
            Currency::getList()
        ));
        $this->setTokenSignatures([$faker->sha256]);
        $this->setTokenSignature($faker->sha256);
        $this->setTokenSignedKey($faker->sha256);
        $this->setTokenSignedMessage($faker->sha256);
        $this->setTokenProtocolVersion('ECv2');
    }

    private function setTokenAttributesNull()
    {
        $this->setTokenSignatures(null);
        $this->setTokenSignature(null);
        $this->setTokenSignedKey(null);
        $this->setTokenSignedMessage(null);
        $this->setTokenProtocolVersion(null);
    }

    private function getToken()
    {
        $faker = Faker::getInstance();

        return json_encode([
            'signature'              => $faker->sha256,
            'protocolVersion'        => 'ECv2',
            'signedMessage'          => $faker->sha256,
            'intermediateSigningKey' => [
                'signedKey'  => $faker->sha256,
                'signatures' => [$faker->sha256],
            ],
        ]);
    }
}
