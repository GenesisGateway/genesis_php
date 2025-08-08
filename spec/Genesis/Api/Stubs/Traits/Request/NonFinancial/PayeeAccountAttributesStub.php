<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\PayeeAccountAttributes;

/**
 * Class PayeeAccountAttributesStub
 *
 * Used to spec PayeeAccountAttributes trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class PayeeAccountAttributesStub
{
    use PayeeAccountAttributes;
    use MagicAccessors;

    public function updateRequestPath(){}
}
