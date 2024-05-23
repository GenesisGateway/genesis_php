<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\Request\NonFinancial\PaymentDetails;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class PaymentDetailsStub
 *
 * Used to spec PaymentDetails trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class PaymentDetailsStub
{
    use PaymentDetails;
    use RestrictedSetter;
}
