<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\Request\NonFinancial\ProcessingType;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class ProcessingTypeStub
 * @package spec\Genesis\Api\Traits\Request\NonFinancial
 */
class ProcessingTypeStub
{
    use ProcessingType;
    use RestrictedSetter;
}
