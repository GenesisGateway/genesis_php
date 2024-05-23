<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\Request\NonFinancial\CustomerInformation;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class CustomerInformationStub
 *
 * Used to spec CustomerInformation trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class CustomerInformationStub
{
    use CustomerInformation;
    use RestrictedSetter;
}
