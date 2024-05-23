<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial;

use Genesis\Api\Traits\Request\Financial\FundingAttributes;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class FundingAttributesStub
 *
 * Used to spec FundingAttributes Trait
 *
 * @package spec\Genesis\Api\Traits\Request\Financial
 */
class FundingAttributesStub
{
    use FundingAttributes;
    use RestrictedSetter;
}
