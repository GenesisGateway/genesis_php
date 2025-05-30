<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycIdentityVerifications;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class KycIdentityVerificationsStub
 *
 * Used to spec KycIdentityVerificationsStub trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class KycIdentityVerificationsStub
{
    use KycIdentityVerifications;
    use MagicAccessors;
    use RestrictedSetter;
}
