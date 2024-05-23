<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\VerificationDocumentTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class VerificationDocumentTypesSpec
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
 */
class VerificationDocumentTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(VerificationDocumentTypes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
