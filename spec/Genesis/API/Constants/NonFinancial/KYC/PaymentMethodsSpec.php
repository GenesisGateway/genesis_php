<?php

namespace spec\Genesis\API\Constants\NonFinancial\KYC;

use Genesis\API\Constants\NonFinancial\KYC\PaymentMethods;
use PhpSpec\ObjectBehavior;

/**
 * Class PaymentMethods
 * @package spec\Genesis\API\Constants\NonFinancial\KYC
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
