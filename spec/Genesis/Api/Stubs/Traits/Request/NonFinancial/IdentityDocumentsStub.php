<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\IdentityDocuments;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class IdentityDocumentsStub
 *
 * Used to spec IdentityDocuments trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class IdentityDocumentsStub
{
    use IdentityDocuments;
    use MagicAccessors;
    use RestrictedSetter;
}
