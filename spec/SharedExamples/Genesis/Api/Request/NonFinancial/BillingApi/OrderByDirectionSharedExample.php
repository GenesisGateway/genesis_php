<?php

namespace spec\SharedExamples\Genesis\Api\Request\NonFinancial\BillingApi;

use Genesis\Exceptions\InvalidArgument;

/**
 * Trait OrderByDirectionSharedExample
 * @package spec\SharedExamples\Genesis\Api\Request\NonFinancial\BillingApi
 */
trait OrderByDirectionSharedExample
{
    public function it_should_set_order_by_direction()
    {
        $this->setRequestParameters();

        $this->setOrderByDirection('desc');

        $this->getDocument()->shouldContain('byDirection');
    }

    public function it_should_fail_with_invalid_order_by_direction()
    {
        $this->setRequestParameters();

        $this->shouldThrow(InvalidArgument::class)->during('setOrderByDirection', ['invalid_value']);
    }
}
