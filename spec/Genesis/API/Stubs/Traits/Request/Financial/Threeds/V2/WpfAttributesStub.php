<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\Threeds\V2\WpfAttributes;

/**
 * Class WpfAttributesStub
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2
 */
class WpfAttributesStub
{
    use MagicAccessors, WpfAttributes;

    public function getStructure()
    {
        return $this->getThreedsV2ParamsStructure();
    }
}
