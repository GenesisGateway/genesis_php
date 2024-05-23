<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\Business;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\Business\BusinessAttributes;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class AirlinesAirCarriersAttributesStub
 *
 * Used to spec BusinessAttributes trait
 *
 * @package spec\Genesis\Api\Traits\Request\Financial\Business
 */
class BusinessAttributesStub
{
    use BusinessAttributes;
    use MagicAccessors;
    use RestrictedSetter;
}
