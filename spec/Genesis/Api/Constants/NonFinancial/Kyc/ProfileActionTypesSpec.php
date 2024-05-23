<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\ProfileActionTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class ProfileActionTypes
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
 */
class ProfileActionTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ProfileActionTypes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
