<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\Kyc\KycDocumentVerifications;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class KycDocumentVerificationsStub
 *
 * Used to spec KycDocumentVerifications trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class KycDocumentVerificationsStub
{
    use KycDocumentVerifications;
    use MagicAccessors;
    use RestrictedSetter;
}
