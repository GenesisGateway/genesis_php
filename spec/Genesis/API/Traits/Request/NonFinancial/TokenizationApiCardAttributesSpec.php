<?php

namespace spec\Genesis\API\Traits\Request\NonFinancial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\NonFinancial\TokenizationApiCardAttributesStub;
use spec\SharedExamples\Faker;

class TokenizationApiCardAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(TokenizationApiCardAttributesStub::class);
    }

    public function it_should_set_card_number_correctly()
    {
        $card_number = Faker::getInstance()->creditCardNumber();

        $this->shouldNotThrow()->during(
            'setCardNumber',
            [$card_number]
        );

        $this->getCardNumber()->shouldBe($card_number);
    }

    public function it_should_set_card_holder_correctly()
    {
        $name = Faker::getInstance()->name();

        $this->shouldNotThrow()->during(
            'setCardHolder',
            [$name]
        );

        $this->getCardHolder()->shouldBe($name);
    }

    public function it_should_set_expiration_month_correctly()
    {
        $month = Faker::getInstance()->date('m');

        $this->shouldNotThrow()->during(
            'setExpirationMonth',
            [$month]
        );

        $this->getExpirationMonth()->shouldBe($month);
    }

    public function it_should_set_expiration_year_correctly()
    {
        $year = Faker::getInstance()->date('Y');

        $this->shouldNotThrow()->during(
            'setExpirationYear',
            [$year]
        );

        $this->getExpirationYear()->shouldBe($year);
    }
}
