<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\OnlineBankingPayments;

use Genesis\Api\Traits\Request\Financial\OnlineBankingPayments\PayerAttributes;
use Genesis\Api\Traits\RestrictedSetter;
use Genesis\Api\Traits\MagicAccessors;

/**
 * Class PayerAttributesStub
 *
 * Used to spec PayerAttributes trait
 *
 * @package spec\Genesis\Api\Traits\Request\Financial\OnlineBankingPayments
 */
class PayerAttributesStub
{
    use PayerAttributes;
    use RestrictedSetter;
    use MagicAccessors;
}
