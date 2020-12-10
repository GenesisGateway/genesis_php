<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\Threeds\V2\Control;

/**
 * Class ControlStub
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2
 */
class ControlStub
{
    use MagicAccessors, Control;

    public function getStructure()
    {
        return $this->getControlAttributes();
    }
}
