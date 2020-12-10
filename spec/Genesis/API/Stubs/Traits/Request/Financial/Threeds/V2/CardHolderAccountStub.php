<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\Threeds\V2\CardHolderAccount;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class CardHolderAccountStub
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2
 */
class CardHolderAccountStub
{
    use MagicAccessors, RestrictedSetter, CardHolderAccount;

    public function getStructure()
    {
        return $this->getCardHolderAccountAttributes();
    }
}
