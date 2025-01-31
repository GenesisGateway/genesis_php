<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\Request\NonFinancial\DateAttributes;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class DateAttributesStub
 *
 * Used to test Date Attributes Trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class DateAttributesStub
{
    use DateAttributes {
        validateGroupDateRequirements as public publicValidateGroupRequirements;
        validateDatesMaxDifference as public publicValidateDatesMaxDifference;
    }
    use RestrictedSetter;
}
