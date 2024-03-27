<?php

namespace spec\Genesis\API\Traits\Request\NonFinancial\BillingApi;

use PhpSpec\ObjectBehavior;
use Genesis\Exceptions\InvalidArgument;
use spec\SharedExamples\Faker;
use spec\Genesis\API\Stubs\Traits\Request\NonFinancial\BillingApi\OrderByDirectionStub;

class OrderByDirectionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(OrderByDirectionStub::class);
    }

    public function it_should_fail_with_invalid_value()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setOrderByDirection', ['error_value']);
    }

    public function it_should_not_fail_with_proper_value()
    {
        $this->shouldNotThrow()->during(
            'setOrderByDirection',
            [Faker::getInstance()->randomElement($this->getWrappedObject()->getAllowedValues())]
        );
    }
}
