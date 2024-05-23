<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\TransactionStatuses;
use PhpSpec\ObjectBehavior;

/**
 * Class TransactionStatuses
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
 */
class TransactionStatusesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(TransactionStatuses::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
