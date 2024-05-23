<?php

namespace spec\Genesis\Api\Constants\Transaction\Parameters\OnlineBanking;

use Genesis\Api\Constants\Transaction\Parameters\OnlineBanking\PayoutPaymentTypesParameters;
use PhpSpec\ObjectBehavior;

/**
 * Class PayoutPaymentTypesParametersSpec
 * @package spec\Genesis\Api\Constants\Transaction\Parameters\OnlineBanking
 */
class PayoutPaymentTypesParametersSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PayoutPaymentTypesParameters::class);
    }

    public function it_should_be_array()
    {
        $this::getAll()->shouldBeArray();
    }
}
