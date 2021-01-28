<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial;

use Genesis\API\Traits\Request\Financial\BirthDateAttributes;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class BirthDateAttributesStub
 *
 * Used to spec BirthDateAttributesSpec
 *
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial
 */
class BirthDateAttributesStub
{
    use RestrictedSetter, BirthDateAttributes;
}
