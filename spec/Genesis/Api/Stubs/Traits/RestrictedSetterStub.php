<?php

namespace spec\Genesis\Api\Stubs\Traits;

use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class RestrictedSetterStub
 * @package spec\Genesis\Api\Stubs\Traits
 */
class RestrictedSetterStub
{
    use RestrictedSetter {
        setLimitedString as public publicSetLimitedString;
        parseDate as public publicParseDate;
        allowedOptionsSetter as public publicAllowedOptionsSetter;
        parseAmount as public publicParseAmount;
        parseArrayOfStrings as public publicParseArrayOfStrings;
    }

    /**
     * Property for testing into Spec
     *
     * @var string
     */
    public $test_field;
}
