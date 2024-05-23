<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial;

use Genesis\Api\Traits\Request\Financial\CustomerIdentificationData;

/**
 * Class RestrictedSetterStub
 * @package spec\Genesis\Api\Stubs\Traits
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