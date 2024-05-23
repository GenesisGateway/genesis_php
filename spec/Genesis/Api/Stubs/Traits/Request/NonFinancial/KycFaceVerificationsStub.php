<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycFaceVerifications;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class KycFaceVerificationsStub
 *
 * Used to spec KycFaceVerifications trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class KycFaceVerificationsStub
{
    use KycFaceVerifications;
    use MagicAccessors;
    use RestrictedSetter;
}
