<?php

namespace spec\Genesis\API\Request\Financial\Alternatives;

use Genesis\API\Request\Financial\Alternatives\PPRO;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class PPROSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(PPRO::class);
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setPaymentType(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_bic_for_giropay()
    {
        $this->setRequestParameters();
        $this->setPaymentType('giropay');
        $this->setBic(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_iban_for_giropay()
    {
        $this->setRequestParameters();
        $this->setPaymentType('giropay');
        $this->setIban(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_customer_email_for_przelewy24()
    {
        $this->setRequestParameters();
        $this->setPaymentType('przelewy24');
        $this->shouldThrow()->during('setCustomerEmail', [ '' ]);
    }

    public function it_should_fail_when_wrong_country_code_for_safetypay()
    {
        $this->setRequestParameters();
        $this->setPaymentType('safetypay');
        $this->setBillingCountry('BG');
        $this->setCurrency('EUR');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_unsupported_billing_country_parameter()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('ZZ');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_unsupported_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('ABC');

        $this->shouldThrow()->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setPaymentType('trustpay');
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setCurrency('EUR');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCustomerEmail($faker->email);
        $this->setCustomerPhone($faker->phoneNumber);
        $this->setAccountNumber($faker->numberBetween(1, PHP_INT_MAX));
        $this->setBankCode('0000');
        $this->setBic('BOFAGB3SSWI');
        $this->setIban('DE12345678901234567890');
        $this->setAccountPhone($faker->phoneNumber);
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingAddress1($faker->streetAddress);
        $this->setBillingZipCode($faker->postcode);
        $this->setBillingCity($faker->city);
        $this->setBillingState($faker->state);
        $this->setBillingCountry('CZ');
    }
}
