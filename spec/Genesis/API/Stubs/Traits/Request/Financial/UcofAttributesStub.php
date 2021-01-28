<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\UcofAttributes;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class UcofAttributesStub
 *
 * Use for UcofAttributes Trait
 *
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial
 */
class UcofAttributesStub
{
    use RestrictedSetter, MagicAccessors, UcofAttributes;

    public function returnUcofAttributesStructure()
    {
        return $this->getUcofAttributesStructure();
    }
}
