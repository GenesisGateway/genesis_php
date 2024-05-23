<?php

namespace spec\Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Api\Constants\NonFinancial\Kyc\DocumentTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class DocumentTypesSpec
 * @package spec\Genesis\Api\Constants\NonFinancial\Kyc
 */
class DocumentTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(DocumentTypes::class);
    }

    public function it_should_be_array()
    {
        $this->getAll()->shouldBeArray();
    }
}
