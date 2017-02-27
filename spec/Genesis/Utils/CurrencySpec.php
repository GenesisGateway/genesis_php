<?php

namespace spec\Genesis\Utils;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CurrencySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Utils\Currency');
    }

    public function it_should_process_zero_exponent()
    {
        $this->amountToExponent(19.95, 'JPY')->shouldBe('19.95');
    }

    public function it_should_parse_zero_exponent()
    {
        $this->exponentToAmount(1995, 'JPY')->shouldBe('1995');
    }

    public function it_should_process_na_exponent()
    {
        $this->amountToExponent(19.95, 'XAU')->shouldBe('19.95');
    }

    public function it_should_parse_na_exponent()
    {
        $this->exponentToAmount(1995, 'XAU')->shouldBe('1995');
    }

    public function it_should_apply_exponent()
    {
        $this->amountToExponent(19.95, 'USD')->shouldBe('1995');
    }

    public function it_should_remove_exponent()
    {
        $this->exponentToAmount(1995, 'USD')->shouldBe('19.95');
    }

    public function it_should_not_round()
    {
        $this->amountToExponent(314.34, 'USD')->shouldBe('31434');
    }

    public function it_should_fail_parsing_currency()
    {
        $this->amountToExponent(314.34, 'NON')->shouldBe('314.34');
    }

    public function it_should_successfully_parse_three_exponent_currency()
    {
        $this->amountToExponent(199.995, 'KWD')->shouldBe('199995');
    }

    public function it_should_successfully_process_three_exponent_currency()
    {
        $this->exponentToAmount(199995, 'KWD')->shouldBe('199.995');
    }
}
