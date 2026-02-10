<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycBusiness;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class KycBusinessStub
 *
 * Used to spec KycBusiness trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class KycBusinessStub
{
    use KycBusiness;
    use MagicAccessors;
    use RestrictedSetter;
}
