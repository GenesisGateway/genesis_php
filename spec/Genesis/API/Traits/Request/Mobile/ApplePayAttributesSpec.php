<?php

namespace spec\Genesis\API\Traits\Request\Mobile;

use Genesis\Utils\Common as CommonUtils;
use spec\Genesis\API\Stubs\Traits\Request\Mobile\ApplePayAttributesStub;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;

class ApplePayAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(ApplePayAttributesStub::class);
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
        $this->getPaymentTokenStructure()->shouldContain('paymentData');
        $this->getPaymentTokenStructure()->shouldContain('version');
        $this->getPaymentTokenStructure()->shouldContain('ephemeralPublicKey');
        $this->getPaymentTokenStructure()->shouldContain('displayName');
    }

    public function it_should_not_throw_with_valid_parameter()
    {
        $this->shouldNotThrow()->during('setTokenPublicKeyHash', [Faker::getInstance()->sha256]);
    }

    public function it_should_set_correct_token_attributes()
    {
        $faker = Faker::getInstance();

        $methods = [
            'token_version'                => 'word',
            'token_data'                   => 'text',
            'token_signature'              => 'sha256',
            'token_ephemeral_public_key'   => 'sha256',
            'token_public_key_hash'        => 'sha256',
            'token_transaction_id'         => 'uuid',
            'token_display_name'           => 'word',
            'token_network'                => 'word',
            'token_type'                   => 'word',
            'token_transaction_identifier' => 'sha256',
        ];

        foreach ($methods as $method => $fakerMethod) {
            $data = $faker->{$fakerMethod};
            $requestMethod = CommonUtils::snakeCaseToCamelCase($method);
            $this->{'set' . $requestMethod}($data)->{'get' . $requestMethod}()->shouldBe($data);
        }
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
