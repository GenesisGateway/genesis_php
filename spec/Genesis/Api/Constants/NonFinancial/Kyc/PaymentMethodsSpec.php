<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\PaymentMethods;
use PhpSpec\ObjectBehavior;

/**
 * Class PaymentMethods
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
 */
class PaymentMethodsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PaymentMethods::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
