<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\Threeds\V2\Recurring;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class RecurringStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2
 */
class RecurringStub
{
    use MagicAccessors;
    use Recurring;
    use RestrictedSetter;

    public function getStructure()
    {
        return $this->getRecurringAttributes();
    }
}
