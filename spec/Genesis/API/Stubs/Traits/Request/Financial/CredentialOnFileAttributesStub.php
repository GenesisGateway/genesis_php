<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\CredentialOnFileAttributes;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class CredentialOnFileAttributesStub
 *
 * Use for CredentialOnFailAttributes Trait
 *
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial
 */
class CredentialOnFileAttributesStub
{
    use MagicAccessors, RestrictedSetter, CredentialOnFileAttributes;

    public function returnCredentialOnFileAttributesStructure()
    {
        return $this->getCredentialOnFileAttributesStructure();
    }
}
