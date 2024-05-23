<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\OnlineBankingPayments;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\CustomerAttributes;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class CustomerAttributesStub
 *
 * Used to spec CustomerAttributes trait
 *
 * @package spec\Genesis\Api\Traits\Request\Financial\OnlineBankingPayments
 */
class CustomerAttributesStub
{
    use CustomerAttributes;
    use MagicAccessors;
    use RestrictedSetter;
}
