<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\VerificationLanguages;
use PhpSpec\ObjectBehavior;

/**
 * Class VerificationLanguagesSpec
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
 */
class VerificationLanguagesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(VerificationLanguages::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
