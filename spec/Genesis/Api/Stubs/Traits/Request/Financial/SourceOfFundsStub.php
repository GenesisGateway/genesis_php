<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial;

use Genesis\Api\Traits\Request\Financial\SourceOfFundsAttributes;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class SourceOfFundsStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial
 */
class SourceOfFundsStub
{
    use RestrictedSetter;
    use SourceOfFundsAttributes;

    public function returnSourceOfFundsStructure()
    {
        return $this->getSourceOfFundsStructure();
    }
}
