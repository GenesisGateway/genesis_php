<?php

namespace spec\Genesis\API\Traits\Request\Financial;

use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\Genesis\API\Stubs\Traits\Request\Financial\PurposeOfPaymentAttributesStub;

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
