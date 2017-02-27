<?php

namespace spec\Genesis\Utils;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CountrySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Utils\Country');
    }

    public function it_can_resolve_iso()
    {
        $this->getCountryName('GB')->shouldBe('United Kingdom');
    }

    public function it_can_handle_invalid_iso()
    {
        $this->getCountryName('XX')->shouldBe(false);
    }

    public function it_can_resolve_name()
    {
        $this->getCountryISO('United Kingdom')->shouldBe('GB');
    }

    public function it_can_resolve_name_case_insensitive()
    {
        $this->getCountryISO('united kingdom')->shouldBe('GB');
    }

    public function it_can_handle_invalid_name()
    {
        $this->getCountryISO('Atlantis')->shouldBe(false);
    }
}
