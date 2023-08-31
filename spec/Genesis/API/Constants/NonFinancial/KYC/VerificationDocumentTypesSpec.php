<?php

namespace spec\Genesis\API\Constants\NonFinancial\KYC;

use Genesis\API\Constants\NonFinancial\KYC\VerificationDocumentTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class VerificationDocumentTypesSpec
 * @package spec\Genesis\API\Constants\NonFinancial\KYC
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
