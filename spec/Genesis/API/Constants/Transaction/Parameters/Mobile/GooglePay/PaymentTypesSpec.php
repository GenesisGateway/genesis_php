<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters\Mobile\GooglePay;

use Genesis\API\Constants\Transaction\Parameters\Mobile\GooglePay\PaymentTypes;
use PhpSpec\ObjectBehavior;

class PaymentTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PaymentTypes::class);
    }

    public function it_should_be_array_allowed_payment_types()
    {
        $this->getAllowedPaymentTypes()->shouldBeArray();
    }

    public function it_should_not_be_empty_get_allowed_payment_types()
    {
        $this->getAllowedPaymentTypes()->shouldNotBeEqualTo([]);
    }
}
