<?php

namespace spec\Genesis\API\Traits\Request\NonFinancial;

use Genesis\API\Constants\NonFinancial\KYC\PaymentMethods;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\NonFinancial\DepositLimitsStub;

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
