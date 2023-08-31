<?php

namespace spec\Genesis\API\Stubs\Traits\Request\NonFinancial;

use \Genesis\API\Traits\MagicAccessors;
use \Genesis\API\Traits\RestrictedSetter;
use \Genesis\API\Traits\Request\NonFinancial\KYC\KycBackgroundChecksVerifications;

/**
 * Class KycBackgroundChecksVerificationsStub
 *
 * Used to spec KycBackgroundChecksVerifications trait
 *
 * @package spec\Genesis\API\Stubs\Traits\Request\NonFinancial
 */
class KycBackgroundChecksVerificationsStub
{
    use KycBackgroundChecksVerifications, MagicAccessors, RestrictedSetter;
}
