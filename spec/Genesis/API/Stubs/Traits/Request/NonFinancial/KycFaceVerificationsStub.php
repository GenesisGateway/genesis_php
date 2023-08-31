<?php

namespace spec\Genesis\API\Stubs\Traits\Request\NonFinancial;

use \Genesis\API\Traits\MagicAccessors;
use \Genesis\API\Traits\RestrictedSetter;
use \Genesis\API\Traits\Request\NonFinancial\KYC\KycFaceVerifications;

/**
 * Class KycFaceVerificationsStub
 *
 * Used to spec KycFaceVerifications trait
 *
 * @package spec\Genesis\API\Stubs\Traits\Request\NonFinancial
 */
class KycFaceVerificationsStub
{
    use KycFaceVerifications, MagicAccessors, RestrictedSetter;
}
