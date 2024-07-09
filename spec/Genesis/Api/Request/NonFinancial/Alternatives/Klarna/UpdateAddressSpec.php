<?php

namespace spec\Genesis\Api\Request\NonFinancial\Alternatives\Klarna;

use Genesis\Api\Request\NonFinancial\Alternatives\Klarna\UpdateAddress;
use Genesis\Builder;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

/**
 * Class UpdateAddressSpec
 * @package spec\Genesis\Api\Request\NonFinancial\Alternatives\Klarna
 */
class UpdateAddressSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(UpdateAddress::class);
    }

    public function it_should_use_builder_xml()
    {
        $this->getApiConfig('format')->shouldBe(Builder::XML);
    }

    public function it_should_contain_correct_parent_node()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldContain('update_order_address_request');
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'billing_country',
            'shipping_country'
        ]);
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingAddress1($faker->streetAddress);
        $this->setBillingZipCode($faker->postcode);
        $this->setBillingCity($faker->city);
        $this->setBillingState($faker->state);
        $this->setBillingCountry($faker->countryCode());

        $this->setShippingFirstName($faker->firstName);
        $this->setShippingLastName($faker->lastName);
        $this->setShippingAddress1($faker->streetAddress);
        $this->setShippingZipCode($faker->postcode);
        $this->setShippingCity($faker->city);
        $this->setShippingState($faker->state);
        $this->setShippingCountry($faker->countryCode());
    }
}
