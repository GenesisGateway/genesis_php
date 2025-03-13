<?php

namespace spec\Genesis\Api\Request\NonFinancial\Installments;

use Genesis\Api\Request\NonFinancial\Installments\Fetch;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class FetchSpec extends ObjectBehavior
{
    use RequestExamples;

    private $amount      = '564321';
    private $currency    = 'GBP';
    private $card_number = '4111111111111111';

    public function it_is_initializable()
    {
        $this->shouldHaveType(Fetch::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'amount',
            'currency',
            'card_number',
        ]);
    }

    public function it_should_not_throw_with_correct_parameters()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_sets_amount_correctly()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldContain('"amount":' . $this->amount);
    }

    public function it_throws_when_amount_is_negative()
    {
        $this->setRequestParameters();
        $this->setAmount('-123456');
        $this->shouldThrow(InvalidArgument::class)->during('getDocument');
    }

    public function it_throws_when_amount_is_not_valid()
    {
        $this->setRequestParameters();
        $this->setAmount('text');
        $this->shouldThrow(InvalidArgument::class)->during('getDocument');
    }

    public function it_throws_when_currency_is_not_valid()
    {
        $this->setRequestParameters();
        $this->setCurrency('KKK');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_sets_card_number_to_string()
    {
        $this->setRequestParameters();
        $this->setCardNumber(4111111111111111);
        $this->getDocument()->shouldBeString();
    }

    public function it_throws_when_card_number_is_not_valid()
    {
        $this->setRequestParameters();
        $this->setCardNumber('1235abcd');
        $this->shouldThrow(InvalidArgument::class)->during('getDocument');
    }

    public function it_builds_correct_request_path()
    {
        $this->getRequestPath()->shouldBe("installments/");
    }

    private function setRequestParameters()
    {
        $this->setAmount($this->amount);
        $this->setCurrency($this->currency);
        $this->setCardNumber($this->card_number);
    }
}
