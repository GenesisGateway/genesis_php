<?php

namespace spec\Genesis\Api\Request\Financial\GiftCards;

use Genesis\Api\Request\Financial\GiftCards\Tcs;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\GiftCards\TokenAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class TcsSpec extends ObjectBehavior
{
    use RequestExamples;
    use TokenAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Tcs::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'amount',
            'currency',
            'card_number'
        ]);
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

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCurrency('EUR');
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setCardNumber('6051460092247044443');
        $this->setCvv(sprintf("%06s", $faker->numberBetween(100000, 999999)));
    }
}
