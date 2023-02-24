<?php

namespace spec\Genesis\API\Constants\NonFinancial\KYC;

use Genesis\API\Constants\NonFinancial\KYC\DeviceFingerprintTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class DeviceFingerprintTypesSpec
 * @package spec\Genesis\API\Constants\NonFinancial\KYC
 */
class DeviceFingerprintTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(DeviceFingerprintTypes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
