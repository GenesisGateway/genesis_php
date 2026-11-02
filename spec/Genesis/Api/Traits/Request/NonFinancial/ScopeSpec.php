<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial;

use Genesis\Api\Constants\NonFinancial\Scopes;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\ScopeStub;

class ScopeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(ScopeStub::class);
    }

    public function it_should_accept_a_confirmed_value()
    {
        $value = $this->getConfirmedScope();

        $this->setScope($value)->getScope()->shouldBe($value);
    }

    public function it_should_fail_with_invalid_string()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setScope', ['invalid_scope']);
    }

    public function it_should_fail_with_boolean()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setScope', [true]);
    }

    public function it_should_fail_with_integer()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setScope', [0]);
    }

    public function it_should_clear_value_when_set_to_null()
    {
        $this->setScope(null)->getScope()->shouldBeNull();
    }

    /**
     * First entry of the confirmed scope catalogue (deterministic).
     *
     * @return string
     */
    private function getConfirmedScope()
    {
        $scopes = Scopes::getAll();

        return reset($scopes);
    }
}
