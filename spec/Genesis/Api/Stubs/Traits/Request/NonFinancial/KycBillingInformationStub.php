<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\Request\NonFinancial\KycBillingInformation;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class KycBillingInformationStub
 *
 * Used to spec KycBillingInformation trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class KycBillingInformationStub
{
    use KycBillingInformation;
    use RestrictedSetter;
}
