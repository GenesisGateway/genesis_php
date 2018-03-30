<?php

namespace spec\Genesis\API\Request\Financial\GiftCards;

use PhpSpec\ObjectBehavior;

class FashionchequeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\GiftCards\Fashioncheque');
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_fails_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_fails_when_missing_required_parameters()
    {
        $this->setRequestParameters();
        $this->setCardNumber(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_fails_when_card_number_is_not_only_digits()
    {
        $this->setRequestParameters();
        $this->setCardNumber(str_repeat('A', 22));

        $this->shouldThrow(
            $this->getExpectedFieldValueException('card_number')
        )->during('getDocument');
    }

    public function it_fails_when_invalid_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('ABC');

        $this->shouldThrow()->during('getDocument');
    }

    public function it_fails_when_unsupported_currency_parameter()
    {
        $this->setRequestParameters();
        $this->setCurrency('CNY');

        $this->shouldThrow()->during('getDocument');
    }

    public function it_can_build_with_reference_id_parameter()
    {
        $this->setRequestParameters();
        $this->setReferenceId('transaction-reference-id');
        $this->getReferenceId()->shouldBe('transaction-reference-id');
        $this->getDocument()->shouldContain('transaction-reference-id');
    }

    protected function setRequestParameters()
    {
        $faker = \Faker\Factory::create();

        $faker->addProvider(new \Faker\Provider\Payment($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency('EUR');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setCardNumber('6046425117120757123');
        $this->setCvv(sprintf("%06s", $faker->numberBetween(100000, 999999)));
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
