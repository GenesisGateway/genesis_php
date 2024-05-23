<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial;

use Genesis\Api\Constants\NonFinancial\Kyc\PaymentMethods;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\DepositLimitsStub;

class DepositLimitsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(DepositLimitsStub::class);
    }

    public function it_should_set_payment_method_correctly()
    {
        $allowed = PaymentMethods::getAll();

        foreach ($allowed AS $method) {
            $this->shouldNotThrow()->during(
                'setPaymentMethod',
                [$method]
            );
        }
    }

    public function it_should_fail_when_payment_method_is_invalid()
    {
        $this->shouldThrow()->during(
            'setPaymentMethod',
            [88]
        );
    }
}
