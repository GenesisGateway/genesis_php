<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\Threeds\V2\Sdk;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class SdkStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2
 */
class SdkStub
{
    use MagicAccessors;
    use RestrictedSetter;
    use Sdk;

    public function getStructure()
    {
        return $this->getSdkAttributes();
    }
}
