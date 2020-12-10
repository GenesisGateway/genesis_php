<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount;

use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\UpdateIndicators;
use PhpSpec\ObjectBehavior;

class UpdateIndicatorsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(UpdateIndicators::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
