<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\Threeds\V2\Recurring;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class RecurringStub
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2
 */
class RecurringStub
{
    use MagicAccessors, RestrictedSetter, Recurring;

    public function getStructure()
    {
        return $this->getRecurringAttributes();
    }
}
