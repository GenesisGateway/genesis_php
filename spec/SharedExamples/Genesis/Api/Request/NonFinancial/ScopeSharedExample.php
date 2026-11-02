<?php

namespace spec\SharedExamples\Genesis\Api\Request\NonFinancial;

use Genesis\Api\Constants\NonFinancial\Scopes;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait ScopeSharedExample
 *
 * Coverage of the required `scope` filter. A random value from the confirmed
 * catalogue is used for each run.
 *
 * @package spec\SharedExamples\Genesis\Api\Request\NonFinancial
 */
trait ScopeSharedExample
{
    public function it_should_fail_with_invalid_scope_string()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setScope', ['invalid_scope']);
    }

    public function it_should_fail_with_boolean_scope()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setScope', [true]);
    }

    public function it_should_fail_with_integer_scope()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setScope', [0]);
    }

    public function it_should_clear_scope_when_set_to_null()
    {
        $this->setScope(null)->getScope()->shouldBeNull();
    }

    public function it_should_contain_scope_in_document()
    {
        $this->setDefaultRequestParameters();
        $this->getDocument()->shouldContain('scope');
    }

    public function it_should_fail_when_missing_required_scope()
    {
        $this->setDefaultRequestParameters();
        $this->setScope(null);
        $this->shouldThrow()->during('getDocument');
    }

    protected function setScopeParameters()
    {
        $this->setScope($this->getConfirmedScope());
    }

    /**
     * A random scope value from the confirmed catalogue.
     *
     * @return string
     */
    protected function getConfirmedScope()
    {
        $scopes = Scopes::getAll();

        return $scopes[array_rand($scopes)];
    }
}
