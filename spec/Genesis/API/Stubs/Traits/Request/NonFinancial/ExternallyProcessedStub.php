<?php

namespace spec\Genesis\API\Stubs\Traits\Request\NonFinancial;

use Genesis\API\Traits\Request\NonFinancial\ExternallyProcessed;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class ExternallyProcessedStub
 * @package spec\Genesis\API\Stubs\Traits\Request\NonFinancial
 */
class ExternallyProcessedStub
{
    use RestrictedSetter, ExternallyProcessed;
}
