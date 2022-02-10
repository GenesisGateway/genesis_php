<?php

namespace spec\Genesis\API\Traits\Request\Mobile;

use Genesis\Utils\Common as CommonUtils;
use spec\Genesis\API\Stubs\Traits\Request\Mobile\GooglePayAttributesStub;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;

class GooglePayAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(GooglePayAttributesStub::class);
    }

    public function it_should_return_string_value_for_payment_token()
    {
        $this->getPaymentTokenStructure()->shouldBeString();
    }

    public function it_should_be_valid_json()
    {
        $this->getPaymentTokenStructure()->shouldBeValidJson();
    }

    public function it_should_return_proper_structure_for_payment_token()
    {
        $this->getPaymentTokenStructure()->shouldContain('signatures');
        $this->getPaymentTokenStructure()->shouldContain('protocolVersion');
        $this->getPaymentTokenStructure()->shouldContain('intermediateSigningKey');
        $this->getPaymentTokenStructure()->shouldContain('signedMessage');
    }

    public function it_should_throw_with_invalid_parameter_for_set_token_signatures()
    {
        $this->shouldThrow()->during('setTokenSignatures', [Faker::getInstance()->sha256]);
    }

    public function it_should_not_throw_with_array_as_parameter_for_set_token_signatures()
    {
        $this->shouldNotThrow()->during('setTokenSignatures', [[Faker::getInstance()->sha256]]);
    }

    public function it_should_set_correct_token_attributes()
    {
        $faker = Faker::getInstance();

        $methods = [
            'token_signature'        => 'sha256',
            'token_protocol_version' => 'word',
            'token_signed_message'   => 'sha256',
            'token_signed_key'       => 'sha256',
        ];

        foreach ($methods as $method => $fakerMethod) {
            $data = $faker->{$fakerMethod};
            $requestMethod = CommonUtils::snakeCaseToCamelCase($method);
            $this->{'set' . $requestMethod}($data)->{'get' . $requestMethod}()->shouldBe($data);
        }

        $tokenSignatures = [$faker->sha256];
        $this->setTokenSignatures($tokenSignatures)->getTokenSignatures()->shouldBe($tokenSignatures);
    }

    public function getMatchers()
    {
        return [
            'beValidJson' => function ($subject) {
                json_decode($subject);
                return json_last_error() === JSON_ERROR_NONE;
            },
        ];
    }
}
