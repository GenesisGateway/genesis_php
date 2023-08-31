<?php

namespace spec\Genesis\API\Constants\NonFinancial\KYC;

use Genesis\API\Constants\NonFinancial\KYC\VerificationSupportedModes;
use PhpSpec\ObjectBehavior;

/**
 * Class VerificationSupportedModesSpec
 * @package spec\Genesis\API\Constants\NonFinancial\KYC
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
