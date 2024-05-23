<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\Request\NonFinancial\DepositLimits;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class DepositLimitsStub
 *
 * Used to spec DepositLimits trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class DepositLimitsStub
{
    use DepositLimits;
    use RestrictedSetter;
}
