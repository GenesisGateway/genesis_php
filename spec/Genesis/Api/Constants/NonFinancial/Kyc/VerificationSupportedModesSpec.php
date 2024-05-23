<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\VerificationSupportedModes;
use PhpSpec\ObjectBehavior;

/**
 * Class VerificationSupportedModesSpec
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
 */
class VerificationSupportedModesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(VerificationSupportedModes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
