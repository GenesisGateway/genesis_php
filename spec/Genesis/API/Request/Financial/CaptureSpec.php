<?php

namespace spec\Genesis\API\Request\Financial;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CaptureSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\Capture');
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
        $this->setTransactionId(mt_rand(0, PHP_INT_MAX));
        $this->setAmount(mt_rand(0, PHP_INT_MAX));
        $this->setCurrency('USD');
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp('127.0.0.1');
        $this->setReferenceId(mt_rand(0, PHP_INT_MAX));
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
