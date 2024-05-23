<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\MpiAttributes;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class MpiAttributesStub
 *
 * Used to spec MpiAttributes trait
 *
 * @package spec\Genesis\Api\Traits\Request\Financial
 */
class MpiAttributesStub
{
    use MagicAccessors;
    use MpiAttributes;
    use RestrictedSetter;

    public function getIs3DSv2()
    {
        return $this->is3DSv2();
    }

    public function return3DSv1ParamsStructure()
    {
        return $this->get3DSv1ParamsStructure();
    }

    public function return3DSv2ParamsStructure()
    {
        return $this->get3DSv2ParamsStructure();
    }

    public function returnMpiParamsStructure()
    {
        return $this->getMpiParamsStructure();
    }
}
