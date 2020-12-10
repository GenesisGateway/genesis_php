<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\Threeds\V2\Browser;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class BrowserStub
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2
 */
class BrowserStub
{
    use MagicAccessors, RestrictedSetter, Browser;

    public function getStructure()
    {
        return $this->getBrowserAttributes();
    }
}
