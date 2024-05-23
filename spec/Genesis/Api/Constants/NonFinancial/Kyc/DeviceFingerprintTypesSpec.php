<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\DeviceFingerprintTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class DeviceFingerprintTypesSpec
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
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
