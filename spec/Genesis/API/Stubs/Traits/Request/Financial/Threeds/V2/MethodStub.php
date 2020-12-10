<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\Threeds\V2\Method;

/**
 * Class MethodStub
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2
 */
class MethodStub
{
    use MagicAccessors, Method;

    public function getStructure()
    {
        return $this->getMethodAttributes();
    }
}
