<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount;

use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\RegistrationIndicators;
use PhpSpec\ObjectBehavior;

class RegistrationIndicatorsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(RegistrationIndicators::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
