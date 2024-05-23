<?php

namespace spec\Genesis\Api\Traits\Request\Financial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\Financial\PurposeOfPaymentAttributesStub;
use spec\SharedExamples\Faker;

class PurposeOfPaymentAttributesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(PurposeOfPaymentAttributesStub::class);
    }

    public function is_should_set_purpose_of_payment()
    {
        $purpose = Faker::getInstance()->lexify('??????');
        $this->setPurposeOfPayment($purpose);
        $this->getPurposeOfPayment()->shouldBe($purpose);
    }
}
