<?php

namespace spec\Genesis\API\Request\Financial;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreditSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\Credit');
    }

    function it_can_build_stucture()
    {
        $this->setRequestParameters();
        $this->generateXML();
        $this->getXMLDocument()->shouldNotBeEmpty();
    }

    function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\BlankRequiredField')->duringSubmitRequest();
    }

    function it_should_send_without_issues()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow('\Genesis\Exceptions\BlankRequiredField')->duringSubmitRequest();
        $this->getGenesisResponse()->shouldNotBeEmpty();
    }

    function setRequestParameters()
    {
        $this->setTransactionId(mt_rand(PHP_INT_SIZE, PHP_INT_MAX));
        $this->setAmount(mt_rand(40, 16244600));
        $this->setCurrency('USD');
        $this->setUsage('Genesis PHP Client Automated testing');
        $this->setRemoteIp('127.0.0.1');
        $this->setReferenceId(mt_rand(0, PHP_INT_MAX));
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
