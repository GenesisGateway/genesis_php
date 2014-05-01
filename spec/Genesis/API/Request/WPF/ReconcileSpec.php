<?php

namespace spec\Genesis\API\Request\WPF;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReconcileSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\WPF\Reconcile');
    }

    function it_can_build_stucture()
    {
        $this->setRequestParameters();
        $this->Build();
        $this->getRequestDocument()->shouldNotBeEmpty();
    }

    function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\BlankRequiredField')->duringSend();
    }

    function it_should_send_without_issues()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow('\Genesis\Exceptions\BlankRequiredField')->duringSend();
        $this->getGenesisResponse()->shouldNotBeEmpty();
    }

    function setRequestParameters()
    {
        $this->setUniqueId(mt_rand(PHP_INT_SIZE, PHP_INT_MAX));
    }

    public function getMatchers()
    {
        return [
            'beEmpty' => function($subject) {
                    return empty($subject);
                },
        ];
    }
}
