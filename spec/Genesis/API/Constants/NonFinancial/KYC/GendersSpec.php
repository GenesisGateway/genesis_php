<?php

namespace spec\Genesis\API\Constants\NonFinancial\KYC;

use Genesis\API\Constants\NonFinancial\KYC\Genders;
use PhpSpec\ObjectBehavior;

/**
 * Class Genders
 * @package spec\Genesis\API\Constants\NonFinancial\KYC
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
