<?php

namespace spec\Genesis\Api\Request\Financial\Alternatives;

use Genesis\Api\Constants\Payment\Methods;
use Genesis\Api\Request\Financial\Alternatives\Ppro;
use Genesis\Exceptions\ErrorParameter;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\PendingPaymentAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class PproSpec extends ObjectBehavior
{
    use PendingPaymentAttributesExamples;
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Ppro::class);
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setPaymentType(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_contain_proper_structure_with_optional_parameters()
    {
        $this->setRequestParameters();

        $this->setPaymentType('safetypay');
        $this->setCurrency('EUR');
        $this->setBillingCountry('DE');
        $this->setBic('AGB3SSWI');
        $this->getDocument()->shouldContain('<bic>AGB3SSWI</bic>');

        $this->setIban('DE12345678901234567890');
        $this->getDocument()->shouldContain('<iban>DE12345678901234567890</iban>');
    }

    public function it_should_contain_proper_structure_without_optional_parameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setPaymentType('safetypay');
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setCurrency('EUR');
        $this->setBillingCountry('DE');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCustomerEmail($faker->email);
        $this->setCustomerPhone($faker->phoneNumber);
        $this->setAccountNumber($faker->numberBetween(1, PHP_INT_MAX));
        $this->setBankCode('0000');
        $this->setAccountPhone($faker->phoneNumber);
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingAddress1($faker->streetAddress);
        $this->setBillingZipCode($faker->postcode);
        $this->setBillingCity($faker->city);
        $this->setBillingState($faker->state);

        $this->getDocument()->shouldNotContain('<bic>');
        $this->getDocument()->shouldNotContain('<iban>');
    }

    public function it_should_fail_when_missing_customer_email_for_przelewy24()
    {
        $this->setRequestParameters();
        $this->setPaymentType('przelewy24');
        $this->shouldThrow(ErrorParameter::class)->during('setCustomerEmail', ['']);
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

    public function it_should_fail_with_trustpay_payment_method()
    {
        $this->setRequestParameters();
        $this->setPaymentType('trustpay');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setPaymentType(Methods::BCMC);
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
        $this->setBillingCountry('BE');
    }
}
