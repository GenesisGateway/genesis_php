<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\ProfileCurrentStatuses;
use PhpSpec\ObjectBehavior;

/**
 * Class ProfileCurrentStatuses
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
 */
class ProfileCurrentStatusesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ProfileCurrentStatuses::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
