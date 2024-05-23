<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\Genders;
use PhpSpec\ObjectBehavior;

/**
 * Class Genders
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
 */
class GendersSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Genders::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
