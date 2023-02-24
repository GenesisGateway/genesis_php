<?php

namespace spec\Genesis\API\Constants\NonFinancial\KYC;

use Genesis\API\Constants\NonFinancial\KYC\CallServiceTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class CallServiceTypesSpec
 * @package spec\Genesis\API\Constants\NonFinancial\KYC
 */
class CallServiceTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CallServiceTypes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
