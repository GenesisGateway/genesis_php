<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial;

use Genesis\API\Traits\Request\Financial\SourceOfFundsAttributes;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class SourceOfFundsStub
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial
 */
class SourceOfFundsStub
{
    use RestrictedSetter, SourceOfFundsAttributes;

    public function returnSourceOfFundsStructure()
    {
        return $this->getSourceOfFundsStructure();
    }
}
