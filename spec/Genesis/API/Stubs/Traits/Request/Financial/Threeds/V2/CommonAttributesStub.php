<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\Threeds\V2\CommonAttributes;

/**
 * Class CommonAttributesStub
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2
 */
class CommonAttributesStub
{
    use MagicAccessors, CommonAttributes;

    public function getStructure()
    {
        return $this->getThreedsV2ParamsStructure();
    }
}
