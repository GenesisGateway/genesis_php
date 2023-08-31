<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial;

use Genesis\API\Traits\Request\Financial\FundingAttributes;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class FundingAttributesStub
 *
 * Used to spec FundingAttributes Trait
 *
 * @package spec\Genesis\API\Traits\Request\Financial
 */
class FundingAttributesStub
{
    use FundingAttributes, RestrictedSetter;
}
