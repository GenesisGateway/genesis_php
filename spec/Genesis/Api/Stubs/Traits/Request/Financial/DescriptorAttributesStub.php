<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\DescriptorAttributes;

/**
 * Class DescriptorAttributesStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial
 */
class DescriptorAttributesStub
{
    use DescriptorAttributes;
    use MagicAccessors;

    public function getStructure()
    {
        return $this->getDynamicDescriptorParamsStructure();
    }
}
