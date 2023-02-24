<?php

namespace spec\Genesis\API\Constants\NonFinancial\KYC;

use Genesis\API\Constants\NonFinancial\KYC\DocumentTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class DocumentTypesSpec
 * @package spec\Genesis\API\Constants\NonFinancial\KYC
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
