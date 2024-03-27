<?php

namespace spec\Genesis\API\Stubs\Traits\Request\NonFinancial\BillingApi;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\RestrictedSetter;
use Genesis\API\Traits\Request\NonFinancial\BillingApi\OrderByDirection;

/**
 * Class OrderByDirectionStub
 *
 * @package spec\Genesis\API\Stubs\Traits\Request\NonFinancial\BillingApi
 */
class OrderByDirectionStub
{
    use OrderByDirection, RestrictedSetter, MagicAccessors;

    public function getAllowedValues()
    {
        return $this->getOrderByDirectionAllowedValues();
    }
}
