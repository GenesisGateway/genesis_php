<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\CvvPresents;
use PhpSpec\ObjectBehavior;

/**
 * Class CvvPresentsSpec
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
 */
class CvvPresentsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CvvPresents::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
