<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\Cards;

use Genesis\API\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\Cards\TokenizationParamsAttributes;
use Genesis\Api\Traits\RestrictedSetter;

class TokenizationParamsAttributesStub
{
    use MagicAccessors;
    use RestrictedSetter;
    use TokenizationParamsAttributes;
}
