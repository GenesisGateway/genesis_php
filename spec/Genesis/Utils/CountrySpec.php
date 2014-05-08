<?php

namespace spec\Genesis\Utils;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CountrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Utils\Country');
    }

    function it_can_resolve_iso()
    {
        $this->getCountryName('GB')->shouldBe('United Kingdom');
    }

    function it_can_resolve_name()
    {
        $this->getCountryISO('United Kingdom')->shouldBe('GB');
    }
}
