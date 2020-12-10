<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk;

use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\ShippingIndicators;
use PhpSpec\ObjectBehavior;

class ShippingIndicatorsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ShippingIndicators::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
