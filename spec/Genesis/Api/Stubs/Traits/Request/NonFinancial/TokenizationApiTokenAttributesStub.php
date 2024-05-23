<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\TokenizationApiTokenAttributes;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class TokenizationApiTokenAttributesStub
 *
 * Used to spec TokenizationApiTokenAttributes trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class TokenizationApiTokenAttributesStub
{
    use MagicAccessors;
    use RestrictedSetter;
    use TokenizationApiTokenAttributes;
}
