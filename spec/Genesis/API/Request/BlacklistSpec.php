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

    function it_can_build_structure()
    {
        $this->setCardNumber('4200000000000000');
        $this->getDocument()->shouldNotBeEmpty();
    }

    function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\BlankRequiredField')->duringGetDocument();
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
