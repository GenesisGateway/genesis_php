<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\Threeds\V2\CardHolderAccount;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class CardHolderAccountStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2
 */
class CardHolderAccountStub
{
    use CardHolderAccount;
    use MagicAccessors;
    use RestrictedSetter;

    public function getStructure()
    {
        return $this->getCardHolderAccountAttributes();
    }
}
