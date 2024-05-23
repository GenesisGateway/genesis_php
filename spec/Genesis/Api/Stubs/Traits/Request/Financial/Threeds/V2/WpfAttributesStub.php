<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\Threeds\V2\WpfAttributes;

/**
 * Class WpfAttributesStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2
 */
class WpfAttributesStub
{
    use MagicAccessors;
    use WpfAttributes;

    public function getStructure()
    {
        return $this->getThreedsV2ParamsStructure();
    }
}
