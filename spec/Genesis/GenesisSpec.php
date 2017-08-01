<?php

namespace spec\Genesis;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GenesisSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith('NonFinancial\Blacklist');
        $this->shouldHaveType('Genesis\Genesis');
    }

    public function it_can_load_request()
    {
        $this->beConstructedWith('NonFinancial\Blacklist');

        $this->request()->shouldHaveType('\Genesis\API\Request\NonFinancial\Blacklist');
    }

    public function it_can_load_deprecated_request()
    {
        $this->beConstructedWith('Financial\Void');

        $this->request()->shouldHaveType('\Genesis\API\Request\Financial\Cancel');
    }

    public function it_can_set_request_property()
    {
        $this->beConstructedWith('NonFinancial\Blacklist');

        $this->request()->shouldHaveType('\Genesis\API\Request\NonFinancial\Blacklist');

        $this->request()->setCardNumber('420000');

        $this->request()->getCardNumber()->shouldBe('420000');
    }

    public function it_can_send_request()
    {
        $this->beConstructedWith('NonFinancial\Blacklist');

        $this->request()->setCardNumber('4200000000000000');

        $this->shouldThrow('\Genesis\Exceptions\ErrorNetwork')->during('execute');

        $this->response()->getResponseObject()->shouldBe(null);
    }
}
