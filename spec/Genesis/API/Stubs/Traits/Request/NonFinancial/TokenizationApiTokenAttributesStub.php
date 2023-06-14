<?php

namespace spec\Genesis\API\Stubs\Traits\Request\NonFinancial;

use Genesis\API\Traits\MagicAccessors;
use \Genesis\API\Traits\Request\NonFinancial\TokenizationApiTokenAttributes;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class TokenizationApiTokenAttributesStub
 *
 * Used to spec TokenizationApiTokenAttributes trait
 *
 * @package spec\Genesis\API\Stubs\Traits\Request\NonFinancial
 */
class TokenizationApiTokenAttributesStub
{
    use TokenizationApiTokenAttributes, MagicAccessors, RestrictedSetter;
}
