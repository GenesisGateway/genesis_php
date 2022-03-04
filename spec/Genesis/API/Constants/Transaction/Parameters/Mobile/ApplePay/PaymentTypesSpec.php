<?php

namespace spec\Genesis\API\Constants\Transaction\Parameters\Mobile\ApplePay;

use PhpSpec\ObjectBehavior;

class PaymentTypesSpec extends ObjectBehavior
{

    public function it_is_initializable()
    {
        $this->shouldHaveType(\Genesis\API\Constants\Transaction\Parameters\Mobile\ApplePay\PaymentTypes::class);
    }

    public function it_should_be_array_allowed_payment_types()
    {
        $this->getAllowedPaymentTypes()->shouldBeArray();
    }

    public function it_should_not_be_empty_array_allowed_payment_types()
    {
        $this->getAllowedPaymentTypes()->shouldNotBeEqualTo([]);
    }
}
