<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount;

use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\SuspiciousActivityIndicators;
use PhpSpec\ObjectBehavior;

class SuspiciousActivityIndicatorsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SuspiciousActivityIndicators::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
