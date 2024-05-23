<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\CallServiceTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class CallServiceTypesSpec
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
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
