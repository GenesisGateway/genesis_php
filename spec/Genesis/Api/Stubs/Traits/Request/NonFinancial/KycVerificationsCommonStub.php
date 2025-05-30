<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycVerificationsCommon;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class KycVerificationsCommonStub
 *
 * Used to spec KycVerificationsCommonStub trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class KycVerificationsCommonStub
{
    use KycVerificationsCommon;
    use MagicAccessors;
    use RestrictedSetter;
}
