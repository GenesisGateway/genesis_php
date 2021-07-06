<?php

namespace spec\Genesis\API;

use Genesis\API\Request\Base\Financial\Cards\CreditCard;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Base\RequestStub;

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

    public function it_should_return_array_with_allowed_zero_amount()
    {
        $this->getMethodAllowedEmptyRequiredAttributes()->shouldContain(CreditCard::REQUEST_KEY_AMOUNT);
    }

    public function it_should_skip_empty_values_for_zero_amount()
    {
        $this->setTreeStructure(['amount' => 0]);

        $this->executeProcessRequestParameters();

        $this->getTreeStructure()->shouldHaveKeyWithValue(CreditCard::REQUEST_KEY_AMOUNT, 0);
    }
}
