<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycVerificationInstructions;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class KycVerificationInstructionsStub
 *
 * Used to spec KycVerificationInstructions trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class KycVerificationInstructionsStub
{
    use KycVerificationInstructions;
    use MagicAccessors;
    use RestrictedSetter;
}
