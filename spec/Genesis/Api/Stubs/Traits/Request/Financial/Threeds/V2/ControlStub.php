<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\Threeds\V2\Control;

/**
 * Class ControlStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2
 */
class ControlStub
{
    use Control;
    use MagicAccessors;

    public function getStructure()
    {
        return $this->getControlAttributes();
    }
}
