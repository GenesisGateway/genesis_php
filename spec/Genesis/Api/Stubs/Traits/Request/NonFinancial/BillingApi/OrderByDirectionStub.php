<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\BillingApi;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\NonFinancial\BillingApi\OrderByDirection;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class OrderByDirectionStub
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\BillingApi
 */
class OrderByDirectionStub
{
    use MagicAccessors;
    use OrderByDirection;
    use RestrictedSetter;

    public function getAllowedValues()
    {
        return $this->getOrderByDirectionAllowedValues();
    }
}
