<?php

namespace spec\Genesis\API\Request\Financial\Mobile;

use Genesis\API\Constants\Transaction\Parameters\Mobile\GooglePay\PaymentTypes;
use Genesis\API\Request\Financial\Mobile\GooglePay;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class GooglePaySpec extends ObjectBehavior
{
    use RequestExamples;

    public function is_it_initializable()
    {
        $this->shouldHaveType(GooglePay::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'payment_type',
            'amount',
            'currency',
            'token_signature',
            'token_signed_key',
            'token_signatures',
            'token_protocol_version',
            'token_signed_message',
        ]);
    }

    public function it_should_throw_when_is_set_wrong_payment_type_parameter()
    {
        $this->setRequestParameters();
        $this->setPaymentType('invalid_type');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_contain_optional_business_attributes()
    {
        $this->setRequestParameters();
        $this->setBusinessEventStartDate(Faker::getInstance()->date());
        $this->getDocument()->shouldContain('business_attributes');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->uuid);
        $this->setPaymentType($faker->randomElement(
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
}
