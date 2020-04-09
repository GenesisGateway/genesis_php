<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial\Refund;

use Genesis\API\Traits\Request\Financial\Refund\BankAttributes;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class BankAttributesStub
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial\Refund
 */
class BankAttributesStub
{
    use RestrictedSetter, BankAttributes;

    public function getStructure()
    {
        return $this->getBankAttributesStructure();
    }
}
