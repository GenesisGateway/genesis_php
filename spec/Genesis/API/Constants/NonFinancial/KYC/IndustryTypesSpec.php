<?php

namespace spec\Genesis\API\Constants\NonFinancial\KYC;

use Genesis\API\Constants\NonFinancial\KYC\IndustryTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class IndustryTypes
 * @package spec\Genesis\API\Constants\NonFinancial\KYC
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
