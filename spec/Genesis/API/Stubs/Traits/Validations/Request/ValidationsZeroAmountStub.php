<?php

namespace spec\Genesis\API\Stubs\Traits\Validations\Request;

use Genesis\API\Traits\Validations\Request\Validations;

class ValidationsZeroAmountStub
{
    use Validations;

    public function allowedZeroAmount()
    {
        return true;
    }

    public function getIsZeroAmountAllowed()
    {
        return $this->isZeroAmountAllowed();
    }

    public function getIsNotNullZeroAmountAllowed($fieldName, $fieldValue)
    {
        return $this->isNotNullZeroAmountAllowed($fieldName, $fieldValue);
    }
}
