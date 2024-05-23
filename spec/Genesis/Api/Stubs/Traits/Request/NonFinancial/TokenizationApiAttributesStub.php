<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\TokenizationApiAttributes;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class TokenizationApiAttributesStub
 *
 * Used to spec TokenizationApiAttributes trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class TokenizationApiAttributesStub
{
    use MagicAccessors;
    use RestrictedSetter;
    use TokenizationApiAttributes;
}
