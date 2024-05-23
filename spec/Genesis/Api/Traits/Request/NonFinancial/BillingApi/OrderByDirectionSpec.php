<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial\BillingApi;

use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\BillingApi\OrderByDirectionStub;
use spec\SharedExamples\Faker;

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
