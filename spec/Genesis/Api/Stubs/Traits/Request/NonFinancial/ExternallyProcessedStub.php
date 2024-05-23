<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\Request\NonFinancial\ExternallyProcessed;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class ExternallyProcessedStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class ExternallyProcessedStub
{
    use ExternallyProcessed;
    use RestrictedSetter;
}
