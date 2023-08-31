<?php

namespace spec\Genesis\API\Stubs\Traits\Request\NonFinancial;

use \Genesis\API\Traits\MagicAccessors;
use \Genesis\API\Traits\RestrictedSetter;
use \Genesis\API\Traits\Request\NonFinancial\KYC\KycVerifications;

/**
 * Class KycVerificationsStub
 *
 * Used to spec KycVerifications trait
 *
 * @package spec\Genesis\API\Stubs\Traits\Request\NonFinancial
 */
class KycVerificationsStub
{
    use KycVerifications, MagicAccessors, RestrictedSetter;
}
