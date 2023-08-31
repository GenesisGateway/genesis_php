<?php

namespace spec\Genesis\API\Constants\NonFinancial\KYC;

use Genesis\API\Constants\NonFinancial\KYC\VerificationAddressesTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class VerificationAddressesTypesSpec
 * @package spec\Genesis\API\Constants\NonFinancial\KYC
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
