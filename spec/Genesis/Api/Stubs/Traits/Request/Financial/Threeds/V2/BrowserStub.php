<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\Threeds\V2\Browser;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class BrowserStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2
 */
class BrowserStub
{
    use Browser;
    use MagicAccessors;
    use RestrictedSetter;

    public function getStructure()
    {
        return $this->getBrowserAttributes();
    }
}
