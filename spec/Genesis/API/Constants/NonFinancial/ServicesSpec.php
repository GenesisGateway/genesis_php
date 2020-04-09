<?php

namespace spec\Genesis\API\Constants\NonFinancial;

use Genesis\API\Constants\NonFinancial\Services;
use PhpSpec\ObjectBehavior;

/**
 * Class ServicesSpec
 * @package spec\Genesis\API\Constants\NonFinancial
 */
class ServicesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Services::class);
    }

    public function it_should_be_array_with_deprecated_classes()
    {
        $this->getServiceDeprecatedRequests()->shouldBeArray();
    }
}
