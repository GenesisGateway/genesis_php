<?php

namespace spec\Genesis\Api\Request\Financial\Wallets;

use Genesis\Api\Constants\Transaction\Parameters\Wallets\PayPal\PaymentTypes;
use Genesis\Api\Request\Financial\Wallets\PayPal;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\Financial\Business\BusinessAttributesExample;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;
use spec\SharedExamples\Genesis\Api\Traits\Request\DocumentAttributesExample;

class PayPalSpec extends ObjectBehavior
{
    use BusinessAttributesExample;
    use DocumentAttributesExample;
    use NeighborhoodAttributesExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(PayPal::class);
    }

    public function it_should_fail_when_missing_required_parameter()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'payment_type',
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url'
        ]);
    }

    public function it_should_throw_when_set_invalid_payment_type()
    {
        $this->setRequestParameters();
        $this->setPaymentType('invalid');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_contain_optional_billing_address_attributes()
    {
        $this->setRequestParameters();
        $this->setBillingFirstName(Faker::getInstance()->word);
        $this->getDocument()->shouldContain('billing_address');
    }

    public function it_should_contain_optional_shipping_address_attributes()
    {
        $this->setRequestParameters();
        $this->setShippingFirstName(Faker::getInstance()->word);
        $this->getDocument()->shouldContain('shipping_address');
    }

    protected function setRequestParameters()
    {
        $faker = Faker::getInstance();

        $this->setTransactionId($faker->uuid);
        $this->setPaymentType($faker->randomElement(
            PaymentTypes::getAllowedPaymentTypes()
        ));
        $this->setAmount($faker->numberBetween(1, 50000));
        $this->setCurrency($faker->randomElement(
            Currency::getList()
        ));
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
    }
}
