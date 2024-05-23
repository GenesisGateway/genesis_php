<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\Threeds\V2\CommonAttributes;

/**
 * Class CommonAttributesStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2
 */
class CommonAttributesStub
{
    use CommonAttributes;
    use MagicAccessors;

    public function getStructure()
    {
        return $this->getThreedsV2ParamsStructure();
    }
}
