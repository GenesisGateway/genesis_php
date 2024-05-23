<?php

namespace spec\Genesis\Api;

use Genesis\Api\Request\Base\Financial\Cards\CreditCard;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Base\RequestStub;

class BaseRequestSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(RequestStub::class);
    }

    public function it_should_return_false_for_non_numeric_amount_during_transformation()
    {
        $this->getTransformAmount('non_numeric', 'EUR')->shouldBe(false);
    }

    public function it_should_return_correct_transformed_amount_for_every_numeric_value()
    {
        $this->getTransformAmount('0', 'EUR')->shouldBe("0");
    }

    public function it_should_return_array_when_call_allowed_empty_required_attributes()
    {
        $this->getMethodAllowedEmptyRequiredAttributes()->shouldBeArray();
    }

    public function it_should_skip_empty_values_for_zero_amount()
    {
        $this->setTreeStructure(['amount' => 0]);

        $this->executeProcessRequestParameters();

        $this->getTreeStructure()->shouldHaveKeyWithValue(CreditCard::REQUEST_KEY_AMOUNT, 0);
    }
}
