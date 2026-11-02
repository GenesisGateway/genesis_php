<?php

namespace spec\Genesis\Api\Request\Financial\Wallets;

use Genesis\Api\Constants\Transaction\Parameters\Wallets\EWallet\PaymentTypes;
use Genesis\Api\Request\Financial\Wallets\EWallet;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class EWalletSpec extends ObjectBehavior
{
    use NeighborhoodAttributesExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(EWallet::class);
    }

    /**
     * Checks all mandatory fields defined in the setRequiredFields() method of the class
     */
    public function it_should_fail_when_missing_required_parameters()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'payment_type',
            'amount',
            'currency',
            'remote_ip',
            'customer_email',
            'customer_phone',
            'return_success_url',
            'return_failure_url',
            'billing_country'
        ]);
    }

    /**
     * Validates that the class throws an exception if an unsupported currency is supplied
     */
    public function it_should_fail_with_invalid_currency()
    {
        $this->setRequestParameters();

        // USD is not allowed; only INR is accepted
        $this->setCurrency('USD');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    /**
     * Validates that an exception is thrown when an invalid payment type is provided
     */
    public function it_should_fail_with_invalid_payment_type()
    {
        $this->setRequestParameters();
        $this->setPaymentType('invalid_wallet');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    /**
     * Validates conditional requirements: billing_state is required when billing_country is US
     */
    public function it_should_fail_when_us_country_without_state()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('US');
        $this->setBillingState(null);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    /**
     * Validates conditional requirements: billing_state is required when billing_country is CA
     */
    public function it_should_fail_when_ca_country_without_state()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('CA');
        $this->setBillingState(null);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    /**
     * Verifies strict URL validation rules on the return success endpoint
     */
    public function it_should_fail_with_invalid_return_success_url()
    {
        $this->shouldThrow(new \Genesis\Exceptions\InvalidArgument('Invalid return_success_url URL is given.'))
            ->during('setReturnSuccessUrl', ['not-a-valid-url']);
    }

    /**
     * Verifies strict URL validation rules on the return failure endpoint
     */
    public function it_should_fail_with_invalid_return_failure_url()
    {
        $this->shouldThrow(new \Genesis\Exceptions\InvalidArgument('Invalid return_failure_url URL is given.'))
            ->during('setReturnFailureUrl', ['not-a-valid-url']);
    }

    /**
     * Verifies that the optional shipping address block is populated correctly inside the request
     */
    public function it_should_contain_optional_shipping_address_attributes()
    {
        $this->setRequestParameters();
        $this->setShippingFirstName($this->getFaker()->firstName);

        $this->getDocument()->shouldContain('shipping_address');
    }

    /**
     * Fully populated request, without the optional shipping address block
     *
     * @return void
     */
    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);

        $this->setPaymentType($faker->randomElement(
            PaymentTypes::getAllowedPaymentTypes()
        ));

        $this->setAmount($faker->numberBetween(1, 50000));
        $this->setCurrency('INR');

        $this->setCustomerEmail($faker->email);
        $this->setCustomerPhone($faker->phoneNumber);

        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);

        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingAddress1($faker->streetAddress);
        $this->setBillingAddress2($faker->streetAddress);
        $this->setBillingZipCode($faker->postcode);
        $this->setBillingCity($faker->city);
        $this->setBillingNeighborhood($faker->word);
        $this->setBillingState($faker->stateAbbr);
        $this->setBillingCountry('IN');
    }
}
