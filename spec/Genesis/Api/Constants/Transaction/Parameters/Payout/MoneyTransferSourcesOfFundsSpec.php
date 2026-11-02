<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\Payout;

use Genesis\Api\Constants\Transaction\Parameters\Payout\MoneyTransferSourcesOfFunds;
use PhpSpec\ObjectBehavior;

class MoneyTransferSourcesOfFundsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(MoneyTransferSourcesOfFunds::class);
    }

    public function it_should_be_array_get_all()
    {
        $this->getAll()->shouldBeArray();
    }

    public function it_should_not_be_empty_array_get_all()
    {
        $this->getAll()->shouldNotBeEqualTo([]);
    }
}
