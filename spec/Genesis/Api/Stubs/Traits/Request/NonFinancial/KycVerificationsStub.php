<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycVerifications;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class KycVerificationsStub
 *
 * Used to spec KycVerifications trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class KycVerificationsStub
{
    use KycVerifications;
    use MagicAccessors;
    use RestrictedSetter;
}
