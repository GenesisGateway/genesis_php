<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycBackgroundChecksVerifications;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class KycBackgroundChecksVerificationsStub
 *
 * Used to spec KycBackgroundChecksVerifications trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class KycBackgroundChecksVerificationsStub
{
    use KycBackgroundChecksVerifications;
    use MagicAccessors;
    use RestrictedSetter;
}
