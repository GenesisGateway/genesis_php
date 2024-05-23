<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\TravelData;

use Genesis\Api\Traits\Request\Financial\TravelData\TravelDataAttributes;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class TravelDataAttributesStub
 *
 * Used to spec TravelDataAttributes trait
 *
 * @package spec\Genesis\Api\Traits\Request\Financial\TravelData
 */
class TravelDataAttributesStub
{
    use TravelDataAttributes;
    use RestrictedSetter;
}
