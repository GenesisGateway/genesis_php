<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\CredentialOnFileAttributes;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class CredentialOnFileAttributesStub
 *
 * Use for CredentialOnFailAttributes Trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial
 */
class CredentialOnFileAttributesStub
{
    use CredentialOnFileAttributes;
    use MagicAccessors;
    use RestrictedSetter;

    public function returnCredentialOnFileAttributesStructure()
    {
        return $this->getCredentialOnFileAttributesStructure();
    }
}
