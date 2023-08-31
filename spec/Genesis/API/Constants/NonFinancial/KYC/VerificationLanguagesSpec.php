<?php

namespace spec\Genesis\API\Constants\NonFinancial\KYC;

use Genesis\API\Constants\NonFinancial\KYC\VerificationLanguages;
use PhpSpec\ObjectBehavior;

/**
 * Class VerificationLanguagesSpec
 * @package spec\Genesis\API\Constants\NonFinancial\KYC
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
