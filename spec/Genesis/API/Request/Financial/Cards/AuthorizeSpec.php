<?php

namespace spec\Genesis\API\Request\Financial\Cards;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthorizeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\Cards\Authorize');
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setCardHolder(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_cc_holder_last_name_parameter()
    {
        $this->setRequestParameters();
        $this->setCardHolder('First');

        $this->shouldThrow(
            $this->getExpectedFieldValueException('card_holder')
        )->during('getDocument');
    }

    public function it_should_fail_when_invalid_cc_holder_parameter()
    {
        $this->setRequestParameters();
        $this->setCardHolder('First$% Last');

        $this->shouldThrow(
            $this->getExpectedFieldValueException('card_holder')
        )->during('getDocument');
    }

    public function it_can_set_cc_holder_parameter_with_special_chars()
    {
        $this->setRequestParameters();
        $this->setCardHolder('Müller O\'Conner');

        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_invalid_credit_card_parameter()
    {
        $this->setRequestParameters();
        $this->setCardNumber('47123');

        $this->shouldThrow(
            $this->getExpectedFieldValueException('card_number')
        )->during('getDocument');
    }

    public function it_should_fail_when_invalid_cc_exp_month_parameter()
    {
        $this->setRequestParameters();
        $this->setExpirationMonth('13');

        $this->shouldThrow(
            $this->getExpectedFieldValueException('expiration_month')
        )->during('getDocument');
    }

    public function it_should_fail_when_invalid_cc_exp_year_parameter()
    {
        $this->setRequestParameters();
        $this->setExpirationYear('201');

        $this->shouldThrow(
            $this->getExpectedFieldValueException('expiration_year')
        )->during('getDocument');
    }

    public function it_should_fail_when_unsupported_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('ABC');

        $this->shouldThrow()->during('getDocument');
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
        $this->setCurrency(
            $faker->randomElement(
                \Genesis\Utils\Currency::getList()
            )
        );
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setCardHolder($faker->name);
        $this->setCardNumber('4200000000000000');
        $this->setCvv(sprintf("%03s", $faker->numberBetween(1, 999)));
        $this->setExpirationMonth($faker->numberBetween(1, 12));
        $this->setExpirationYear($faker->numberBetween(date('Y'), date('Y') + 5));
        $this->setCustomerEmail($faker->email);
        $this->setCustomerPhone($faker->phoneNumber);
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingAddress1($faker->streetAddress);
        $this->setBillingZipCode($faker->postcode);
        $this->setBillingCity($faker->city);
        $this->setBillingState($faker->state);
        $this->setBillingCountry($faker->countryCode);
    }

    protected function getExpectedFieldValueException($field)
    {
        return new \Genesis\Exceptions\InvalidArgument(
            "Please check input data for errors. '{$field}' has invalid format"
        );
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
