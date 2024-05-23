<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\Refund;

use Genesis\Api\Traits\Request\Financial\Refund\BankAttributes;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class BankAttributesStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial\Refund
 */
class BankAttributesStub
{
    use BankAttributes;
    use RestrictedSetter;

    public function getStructure()
    {
        return $this->getBankAttributesStructure();
    }
}
