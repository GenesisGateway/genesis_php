<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial;

use Genesis\API\Traits\Request\Financial\BeneficiaryAttributes;

/**
 * Class BeneficiaryAttributesStub
 *
 * Use for BeneficiaryAttributes trait
 *
 * @package spec\Genesis\API\Stubs\Traits\Request\Financial
 */
class BeneficiaryAttributesStub
{
    use BeneficiaryAttributes;

    public function returnBeneficiaryAttribStructure()
    {
        return $this->getBeneficiaryAttributesStructure();
    }
}
