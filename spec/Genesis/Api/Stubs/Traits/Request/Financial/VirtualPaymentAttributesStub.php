<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\OnlineBankingPayments\VirtualPaymentAddressAttributes;

/**
 * Class VirtualPaymentAttributesStub
 *
 * Used to spec VirtualPaymentAttributes Trait
 *
 * @package spec\Genesis\Api\Request\Financial
 */
class VirtualPaymentAttributesStub
{
    use MagicAccessors;
    use VirtualPaymentAddressAttributes;
}
