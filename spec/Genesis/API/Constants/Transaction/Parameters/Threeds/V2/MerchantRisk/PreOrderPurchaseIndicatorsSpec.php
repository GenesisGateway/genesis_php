<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk;

use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\PreOrderPurchaseIndicators;
use PhpSpec\ObjectBehavior;

class PreOrderPurchaseIndicatorsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PreOrderPurchaseIndicators::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
