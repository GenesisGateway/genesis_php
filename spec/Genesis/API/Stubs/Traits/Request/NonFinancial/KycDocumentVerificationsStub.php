<?php

namespace spec\Genesis\API\Stubs\Traits\Request\NonFinancial;

use \Genesis\API\Traits\MagicAccessors;
use \Genesis\API\Traits\RestrictedSetter;
use \Genesis\API\Traits\Request\NonFinancial\KYC\KycDocumentVerifications;

/**
 * Class KycDocumentVerificationsStub
 *
 * Used to spec KycDocumentVerifications trait
 *
 * @package spec\Genesis\API\Stubs\Traits\Request\NonFinancial
 */
class KycDocumentVerificationsStub
{
    use KycDocumentVerifications, MagicAccessors, RestrictedSetter;
}
