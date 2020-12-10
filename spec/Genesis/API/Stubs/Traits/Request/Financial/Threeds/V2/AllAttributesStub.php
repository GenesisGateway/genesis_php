<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\Threeds\V2\AllAttributes;

/**
 * Class AllAttributesStub
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2
 */
class AllAttributesStub
{
    use MagicAccessors, AllAttributes;

    public function getStructure()
    {
        return $this->getThreedsV2ParamsStructure();
    }
}
