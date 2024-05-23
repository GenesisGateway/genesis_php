<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\Threeds\V2\Purchase;

/**
 * Class PurchaseStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2
 */
class PurchaseStub
{
    use MagicAccessors;
    use Purchase;

    public function getStructure()
    {
        return $this->getPurchaseAttributes();
    }
}
