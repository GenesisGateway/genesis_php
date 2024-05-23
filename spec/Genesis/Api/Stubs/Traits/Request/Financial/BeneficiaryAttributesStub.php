<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial;

use Genesis\Api\Traits\Request\Financial\BeneficiaryAttributes;

/**
 * Class BeneficiaryAttributesStub
 *
 * Use for BeneficiaryAttributes trait
 *
 * @package spec\Genesis\Api\Stubs\Traits\Request\Financial
 */
class BeneficiaryAttributesStub
{
    use BeneficiaryAttributes;

    public function returnBeneficiaryAttribStructure()
    {
        return $this->getBeneficiaryAttributesStructure();
    }
}
