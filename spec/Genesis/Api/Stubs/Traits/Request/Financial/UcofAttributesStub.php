<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\UcofAttributes;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class UcofAttributesStub
 *
 * Use for UcofAttributes Trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial
 */
class UcofAttributesStub
{
    use MagicAccessors;
    use RestrictedSetter;
    use UcofAttributes;

    public function returnUcofAttributesStructure()
    {
        return $this->getUcofAttributesStructure();
    }
}
