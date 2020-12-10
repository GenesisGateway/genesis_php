<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\Threeds\V2\Purchase;

/**
 * Class PurchaseStub
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2
 */
class PurchaseStub
{
    use MagicAccessors, Purchase;

    public function getStructure()
    {
        return $this->getPurchaseAttributes();
    }
}
