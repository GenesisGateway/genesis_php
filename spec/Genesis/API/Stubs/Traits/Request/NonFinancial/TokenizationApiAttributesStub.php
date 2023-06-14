<?php

namespace spec\Genesis\API\Stubs\Traits\Request\NonFinancial;

use \Genesis\API\Traits\MagicAccessors;
use \Genesis\API\Traits\Request\NonFinancial\TokenizationApiAttributes;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class TokenizationApiAttributesStub
 *
 * Used to spec TokenizationApiAttributes trait
 *
 * @package spec\Genesis\API\Stubs\Traits\Request\NonFinancial
 */
class TokenizationApiAttributesStub
{
    use TokenizationApiAttributes, MagicAccessors, RestrictedSetter;
}
