<?php

namespace spec\Genesis\Api\Constants\NonFinancial\BillingApi;

use Genesis\Api\Constants\NonFinancial\BillingApi\StatementStatuses;
use PhpSpec\ObjectBehavior;

/**
 * Class StatementStatusesSpec
 * @package spec\Genesis\Api\Constants\NonFinancial\BillingApi
 */
class StatementStatusesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(StatementStatuses::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }

    public function it_should_contain_the_documented_statuses()
    {
        $this->getAll()->shouldContain('open');
        $this->getAll()->shouldContain('pending');
        $this->getAll()->shouldContain('paid');
        $this->getAll()->shouldContain('bounced');
    }
}
