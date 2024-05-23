<?php

namespace spec\Genesis\Api\Traits\Validations\Request;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Validations\Request\ValidationsZeroAmountStub;

class ValidationsZeroAmountSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(ValidationsZeroAmountStub::class);
    }

    public function it_should_return_true_with_allowed_field_amount()
    {
        $this->getHasAllowedEmptyFields()->shouldBe(true);
    }

    public function it_should_return_true_with_amount_for_amount_key_with_non_null_value()
    {
        $this->getIsNotNullZeroAmountAllowed('amount', '0')->shouldBe(true);
    }
}
