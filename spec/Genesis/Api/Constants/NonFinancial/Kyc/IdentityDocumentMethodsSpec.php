<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\IdentityDocumentMethods;
use PhpSpec\ObjectBehavior;

/**
 * Class IdentityDocumentMethods
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
 */
class IdentityDocumentMethodsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(IdentityDocumentMethods::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
