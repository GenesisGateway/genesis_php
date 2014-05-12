<?php

namespace spec\Genesis\API\Request\Reconcile;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DateRangeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Reconcile\DateRange');
    }

    function it_can_build_stucture()
    {
        $this->setRequestParameters();
        $this->Build();
        $this->getDocument()->shouldNotBeEmpty();
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
        $this->setStartDate('2014-01-01');
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
