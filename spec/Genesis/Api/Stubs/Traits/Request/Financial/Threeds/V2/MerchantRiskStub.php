<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\Threeds\V2\MerchantRisk;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class MerchantRiskStub
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2
 */
class MerchantRiskStub
{
    use MagicAccessors;
    use MerchantRisk;
    use RestrictedSetter;

    public function getStructure()
    {
        return $this->getMerchantRiskAttributes();
    }
}
