<?php

namespace spec\Genesis\API\Stubs\Traits\Request\NonFinancial;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\NonFinancial\IdentityDocuments;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class IdentityDocumentsStub
 *
 * Used to spec IdentityDocuments trait
 *
 * @package spec\Genesis\API\Stubs\Traits\Request\NonFinancial
 */
class IdentityDocumentsStub
{
    use RestrictedSetter, IdentityDocuments, MagicAccessors;
}
