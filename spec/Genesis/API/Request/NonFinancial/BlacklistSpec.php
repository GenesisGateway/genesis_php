<?php

namespace spec\Genesis\API\Request\NonFinancial;

use Genesis\API as API;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BlacklistSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\NonFinancial\Blacklist');
    }

    public function it_can_build_structure()
    {
        $this->setCardNumber('4200000000000000');
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\ErrorParameter')->during('getDocument');
    }

    public function it_should_fail_when_missing_required_parameters()
    {
        $this->setCardNumber(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function getMatchers()
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
        );
    }
}
