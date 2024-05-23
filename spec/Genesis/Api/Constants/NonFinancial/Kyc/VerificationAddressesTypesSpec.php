<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\VerificationAddressesTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class VerificationAddressesTypesSpec
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
 */
class VerificationAddressesTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(VerificationAddressesTypes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
