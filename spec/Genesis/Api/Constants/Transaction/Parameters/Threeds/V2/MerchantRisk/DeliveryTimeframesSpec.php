<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk;

use Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\DeliveryTimeframes;
use PhpSpec\ObjectBehavior;

class DeliveryTimeframesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(DeliveryTimeframes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
