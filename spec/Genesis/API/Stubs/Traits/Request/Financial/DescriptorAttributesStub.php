<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\DescriptorAttributes;

/**
 * Class DescriptorAttributesStub
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial
 */
class DescriptorAttributesStub
{
    use MagicAccessors, DescriptorAttributes;

    public function getStructure()
    {
        return $this->getDynamicDescriptorParamsStructure();
    }
}
