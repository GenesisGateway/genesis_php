<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial;

use Genesis\Api\Traits\Request\Financial\BirthDateAttributes;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class BirthDateAttributesStub
 *
 * Used to spec BirthDateAttributesSpec
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial
 */
class BirthDateAttributesStub
{
    use BirthDateAttributes;
    use RestrictedSetter;
}
