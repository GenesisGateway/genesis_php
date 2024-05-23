<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\IndustryTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class IndustryTypes
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
 */
class IndustryTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(IndustryTypes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
