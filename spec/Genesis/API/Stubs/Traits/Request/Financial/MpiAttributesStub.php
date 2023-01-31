<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\MpiAttributes;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class MpiAttributesStub
 *
 * Used to spec MpiAttributes trait
 *
 * @package spec\Genesis\API\Traits\Request\Financial
 */
class MpiAttributesStub
{
    use MagicAccessors, MpiAttributes, RestrictedSetter;

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
