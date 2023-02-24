<?php

namespace spec\Genesis\API\Constants\NonFinancial\KYC;

use Genesis\API\Constants\NonFinancial\KYC\ProfileActionTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class ProfileActionTypes
 * @package spec\Genesis\API\Constants\NonFinancial\KYC
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
