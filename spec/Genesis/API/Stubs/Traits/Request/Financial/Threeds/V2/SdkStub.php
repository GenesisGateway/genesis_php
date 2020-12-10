<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\Threeds\V2\Sdk;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class SdkStub
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2
 */
class SdkStub
{
    use MagicAccessors, RestrictedSetter, Sdk;

    public function getStructure()
    {
        return $this->getSdkAttributes();
    }
}
