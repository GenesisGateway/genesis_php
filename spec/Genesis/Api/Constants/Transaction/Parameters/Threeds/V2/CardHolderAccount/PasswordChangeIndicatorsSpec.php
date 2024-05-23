<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount;

use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\PasswordChangeIndicators;
use PhpSpec\ObjectBehavior;

class PasswordChangeIndicatorsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PasswordChangeIndicators::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
