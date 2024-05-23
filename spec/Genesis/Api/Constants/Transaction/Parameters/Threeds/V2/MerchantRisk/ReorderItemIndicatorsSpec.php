<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk;

use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\ReorderItemIndicators;
use PhpSpec\ObjectBehavior;

class ReorderItemIndicatorsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ReorderItemIndicators::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
