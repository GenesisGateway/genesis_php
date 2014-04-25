<?php

namespace spec\Genesis\API\Request;

use Genesis\API as API;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

require_once __DIR__ . '/../../SpecHelper.php';

class BlacklistSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Blacklist');
    }

    function it_can_build_stucture()
    {
        $this->setCardNumber('4200000000000000');
        $this->generateXML();
        $this->getXMLDocument()->shouldNotBeEmpty();
    }

    function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\BlankRequiredField')->duringSubmitRequest();
    }

    function it_should_send_without_issues()
    {
        $this->setCardNumber('4200000000000000');
        $this->shouldNotThrow('\Genesis\Exceptions\BlankRequiredField')->duringSubmitRequest();
        $this->getGenesisResponse()->shouldNotBeEmpty();
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
