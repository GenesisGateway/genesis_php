<?php

namespace spec\Genesis\API\Constants\NonFinancial\KYC;

use Genesis\API\Constants\NonFinancial\KYC\TransactionStatuses;
use PhpSpec\ObjectBehavior;

/**
 * Class TransactionStatuses
 * @package spec\Genesis\API\Constants\NonFinancial\KYC
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
