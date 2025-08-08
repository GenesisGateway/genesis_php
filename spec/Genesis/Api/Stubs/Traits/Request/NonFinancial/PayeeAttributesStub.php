<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\PayeeAttributes;

/**
 * Class PayeeAttributesStub
 *
 * Used to spec PayeeAttributes trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial
 */
class PayeeAttributesStub
{
    use PayeeAttributes;
    use MagicAccessors;

    public function updateRequestPath(){}
}
