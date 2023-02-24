<?php

namespace spec\Genesis\API\Constants\NonFinancial\KYC;

use Genesis\API\Constants\NonFinancial\KYC\CVVPresents;
use PhpSpec\ObjectBehavior;

/**
 * Class CVVPresentsSpec
 * @package spec\Genesis\API\Constants\NonFinancial\KYC
 */
class CVVPresentsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CVVPresents::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
