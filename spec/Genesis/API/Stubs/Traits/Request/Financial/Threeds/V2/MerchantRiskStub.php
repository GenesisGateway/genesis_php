<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Traits\MagicAccessors;
use Genesis\API\Traits\Request\Financial\Threeds\V2\MerchantRisk;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class MerchantRiskStub
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2
 */
class MerchantRiskStub
{
    use MagicAccessors, RestrictedSetter, MerchantRisk;

    public function getStructure()
    {
        return $this->getMerchantRiskAttributes();
    }
}
