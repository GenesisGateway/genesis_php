<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\CallVerificationStatuses;
use PhpSpec\ObjectBehavior;

/**
 * Class CallVerificationStatusesSpec
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
 */
class CallVerificationStatusesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CallVerificationStatuses::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
