<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial\OnlineBankingPayments;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\OnlineBankingPayments\CustomerAttributes;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class CustomerAttributesStub
 *
 * Used to spec CustomerAttributes trait
 *
 * @package spec\Genesis\API\Traits\Request\Financial\OnlineBankingPayments
 */
class CustomerAttributesStub
{
    use MagicAccessors, CustomerAttributes, RestrictedSetter;
}
