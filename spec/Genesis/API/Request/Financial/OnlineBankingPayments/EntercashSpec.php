<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments;

use Genesis\API\Request\Financial\OnlineBankingPayments\Entercash;
use PhpSpec\ObjectBehavior;

class EntercashSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\OnlineBankingPayments\Entercash');
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_usage_param()
    {
        $this->setRequestParameters();
        $this->setUsage(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_remote_ip_param()
    {
        $this->setRequestParameters();
        $this->setRemoteIp(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_return_success_url_parameter()
    {
        $this->setRequestParameters();
        $this->setReturnSuccessUrl(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_return_failure_url_parameter()
    {
        $this->setRequestParameters();
        $this->setReturnFailureUrl(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_required_amount_param()
    {
        $this->setRequestParameters();
        $this->setAmount(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_currency_invalid_param()
    {
        $this->setRequestParameters();
        $this->setCurrency('USD');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_country_invalid_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('BG');
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_consumer_reference_invalid_param()
    {
        $this->shouldThrow('\Genesis\Exceptions\ErrorParameter')->during('setConsumerReference', [
            str_repeat('8', $this->object->getWrappedObject()->getMaxConsumerReferenceLen() + 1)
        ]);
    }

    public function it_should_fail_when_de_iban_invalid_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('DE');
        $this->shouldThrow()->during('setIban', ['BG1234']);
    }

    public function it_should_fail_when_at_iban_invalid_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('AT');
        $this->shouldThrow()->during('setIban', ['BG1234']);
    }

    public function it_should_set_de_iban_correctly()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('DE');
        $this->shouldNotThrow()->during('setIban', ['DE12345678901234567890']);
    }

    public function it_should_set_at_iban_correctly()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('AT');
        $this->shouldNotThrow()->during('setIban', ['AT123456789123456789']);
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\Payment($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency('EUR');
        $this->setConsumerReference('4444');
        $this->setCustomerEmail('test@test.com');
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingAddress1($faker->streetAddress);
        $this->setBillingZipCode($faker->postcode);
        $this->setBillingCity($faker->city);
        $this->setBillingState($faker->state);
        $this->setBillingCountry('DE');
    }

    public function getMatchers()
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        );
    }
}
