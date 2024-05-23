<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\Threeds\V2\Method;

/**
 * Class MethodStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2
 */
class MethodStub
{
    use MagicAccessors;
    use Method;

    public function getStructure()
    {
        return $this->getMethodAttributes();
    }
}
