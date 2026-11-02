<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\Scope;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class ScopeStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class ScopeStub
{
    use MagicAccessors;
    use Scope;
    use RestrictedSetter;
}
