<?php

namespace spec\Genesis\API\Constants\NonFinancial\KYC;

use Genesis\API\Constants\NonFinancial\KYC\CallVerificationStatuses;
use PhpSpec\ObjectBehavior;

/**
 * Class CallVerificationStatusesSpec
 * @package spec\Genesis\API\Constants\NonFinancial\KYC
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
