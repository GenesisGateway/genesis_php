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
        $this->getDocument()->shouldNotBeEmpty();
    }

    function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\BlankRequiredField')->duringgetDocument();
    }

    function setRequestParameters()
    {
        $this->setUniqueId(mt_rand(PHP_INT_SIZE, PHP_INT_MAX));
    }

    public function getMatchers()
    {
        return array(
            'beEmpty' => function($subject) {
                    return empty($subject);
                },
        );
    }
}
