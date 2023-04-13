<?php

namespace spec\Genesis\API\Stubs\Traits\Request\Financial;

use Genesis\API\Traits\Request\Financial\CustomerIdentificationData;

/**
 * Class RestrictedSetterStub
 * @package spec\Genesis\API\Stubs\Traits
 */
class CustomerIdentificationDataStub
{
    use CustomerIdentificationData;

    /**
     * Return Customer Identification Data structure
     *
     * @return array
     */
    public function publicGetCustomerIdentificationDataStructure()
    {
        return $this->getCustomerIdentificationDataStructure();
    }
}