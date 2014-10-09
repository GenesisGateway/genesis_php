<?php

namespace spec\Genesis\Utils;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CurrencySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Utils\Currency');
    }

    function it_should_add_exponent()
    {
        $this->realToExponent(19.95, 'USD')->shouldBe(1995);
    }

    function it_should_remove_exponent()
    {
        $this->exponentToReal(1995, 'USD')->shouldBe(19.95);
    }
}
